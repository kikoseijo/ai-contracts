<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Llm;

use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Sunnyface\AiContracts\Support\DeepCloneable;
use Sunnyface\AiContracts\Support\RedisSafeSerialization;
use Sunnyface\Contracts\Casts\CognitivePayloadCast;
use Sunnyface\Contracts\Contracts\CognitiveStateContract;
use Sunnyface\Contracts\Enums\HandlerSlug;
use Sunnyface\Contracts\Enums\TaskStatus;

/**
 * Estado serializable del motor cognitivo.
 *
 * Es la "carpeta blindada" que viaja dentro del ConversationalTransit (la mochila).
 * Diseñada para vivir en Redis durante la ejecución del pipeline y hacer un único
 * flush a PostgreSQL al final del Job (Claim Check Pattern).
 *
 * Inmutabilidad asimétrica (PHP 8.4+):
 *   - Los identificadores usan public private(set): legibles desde fuera,
 *     escribibles solo desde esta clase (constructor / born / mutadores).
 *   - El estado evolutivo igual: with* / add* sobre clones.
 *
 * Fluent interface: cada método de mutación devuelve un clone con el nuevo valor,
 * preservando la semántica inmutable en los Pipes.
 */
final class CognitiveContextDTO extends Data
{
    use DeepCloneable;

    public function __construct(
        // ── Identificadores ───────────────────────────────────────────────────
        public private(set) string $taskId,
        public private(set) string $tenantId,
        public private(set) string $tenantAgentId,
        public private(set) HandlerSlug $handlerSlug,

        /**
         * Sesión de chat asociada a la Task (ULID). Se serializa en Redis para que
         * {@see CognitiveStateContract::thaw} pueda
         * rehidratar prefetchedChatMessages sin depender solo de PostgreSQL en caliente.
         */
        public private(set) ?string $chatSessionId = null,

        // ── Estado evolutivo (mutable solo desde esta clase) ──────────────────

        public private(set) TaskStatus $status = TaskStatus::Pending,

        /** Payload de entrada tal como lo envió el Spoke. */
        #[WithCast(CognitivePayloadCast::class)]
        public private(set) ?\Sunnyface\Contracts\Data\Spoke\Payloads\BasePayloadData $inputPayload = null,

        /** Payload de salida construido por los Pipes. Se escribirá en Task::output_payload. */
        #[WithCast(\Sunnyface\Contracts\Casts\CognitiveOutputPayloadCast::class)]
        public private(set) ?\Sunnyface\Contracts\Data\Spoke\Payloads\BaseOutputPayloadData $outputPayload = null,

        /**
         * Historial de mensajes LLM (formato OpenAI: [{role, content}]).
         * Se escribirá en Task::messages_history al hacer flush.
         *
         * @var array<int, array<string, mixed>>
         */
        public private(set) array $messagesHistory = [],

        /**
         * Texto de contexto recuperado por el SemanticSearchPipe.
         * Son strings planos (sin modelos Eloquent) para garantizar serialización limpia.
         *
         * @var array<int, string>
         */
        public private(set) array $retrievedContextText = [],

        /** @var array<int, WorkerResultDTO> */
        public private(set) array $telemetry = [],

        /**
         * Traza de ejecución de herramientas (tool calling) para auditoría / Panóptico.
         * Persistido en Task::tool_executions al hacer flush.
         *
         * @var array<int, ToolExecutionDTO>
         */
        public private(set) array $toolExecutions = [],

        /**
         * Historial de chat precargado por el Job (formato OpenAI), antes del pipeline.
         * Evita ChatSession::find dentro de los Pipes.
         *
         * @var array<int, array<string, mixed>>
         */
        public private(set) array $prefetchedChatMessages = [],

        /** @var array<int, LedgerEntryDTO> */
        public private(set) array $statusLedger = [],

        /** Detalles del error si el pipeline falla. Se escribirá en Task::error_details. */
        public private(set) ?array $errorDetails = null,

        /**
         * Estado efímero del pipeline de ingesta Knowledge Vault (Claim Check, solo Hub).
         * Claves usadas: local_tmp_rel_path, local_tmp_abs_path, raw_text, vault_status,
         * vault_chunks (listas de {chunk_index, content, embedding?}).
         *
         * @var array<string, mixed>
         */
        public private(set) array $vaultTransit = [],
    ) {}

    // ── Factory de nacimiento ─────────────────────────────────────────────────

    /**
     * Crea un DTO recién nacido con la entrada 'Pending' ya sembrada en statusLedger.
     * Usar este método en lugar de new() garantiza que el estado inicial queda trazado.
     */
    public static function born(
        string $taskId,
        string $tenantId,
        string $tenantAgentId,
        HandlerSlug $handlerSlug,
        ?\Sunnyface\Contracts\Data\Spoke\Payloads\BasePayloadData $inputPayload = null,
        ?string $chatSessionId = null,
        array $prefetchedChatMessages = [],
    ): self {
        $now = microtime(true);

        return new self(
            taskId: $taskId,
            tenantId: $tenantId,
            tenantAgentId: $tenantAgentId,
            handlerSlug: $handlerSlug,
            inputPayload: $inputPayload,
            chatSessionId: $chatSessionId,
            prefetchedChatMessages: RedisSafeSerialization::sanitize($prefetchedChatMessages),
            statusLedger: [new LedgerEntryDTO(status: 'Pending', timestamp: $now, duration_ms: 0.0)],
        );
    }

    // ── Métodos de evolución de estado ────────────────────────────────────────

    public function withStatus(TaskStatus $status): self
    {
        if ($status === $this->status) {
            return $this;
        }

        $clone = clone $this;
        $clone->statusLedger = $this->appendLedgerEntry($status);
        $clone->status = $status;

        return $clone;
    }

    public function withInputPayload(\Sunnyface\Contracts\Data\Spoke\Payloads\BasePayloadData $payload): self
    {
        $clone = clone $this;
        $clone->inputPayload = $payload;

        return $clone;
    }

    public function withOutputPayload(\Sunnyface\Contracts\Data\Spoke\Payloads\BaseOutputPayloadData $payload): self
    {
        $clone = clone $this;
        $clone->outputPayload = $payload;

        return $clone;
    }

    /** @param array<string, mixed> $message Formato OpenAI: ['role' => '...', 'content' => '...'] */
    public function addMessage(array $message): self
    {
        $clone = clone $this;
        $clone->messagesHistory[] = RedisSafeSerialization::sanitize($message);

        return $clone;
    }

    /** @param array<int, array<string, mixed>> $messages */
    public function withMessagesHistory(array $messages): self
    {
        $clone = clone $this;
        $clone->messagesHistory = RedisSafeSerialization::sanitize($messages);

        return $clone;
    }

    public function addRetrievedContextText(string $text): self
    {
        $clone = clone $this;
        $clone->retrievedContextText[] = $text;

        return $clone;
    }

    /**
     * Registra la telemetría de un Pipe específico.
     */
    public function recordTelemetry(WorkerResultDTO $entry): self
    {
        $clone = clone $this;
        $clone->telemetry[] = $entry;

        return $clone;
    }

    public function addToolExecution(ToolExecutionDTO $execution): self
    {
        $clone = clone $this;
        $clone->toolExecutions[] = $execution;

        return $clone;
    }

    /**
     * @param  array<int, array<string, mixed>>  $messages  OpenAI-style message arrays
     */
    public function withPrefetchedChatMessages(array $messages): self
    {
        $clone = clone $this;
        $clone->prefetchedChatMessages = RedisSafeSerialization::sanitize($messages);

        return $clone;
    }

    /** @param array<string, mixed> $details */
    public function withError(array $details): self
    {
        $clone = clone $this;
        if ($clone->status !== TaskStatus::Failed) {
            $clone->statusLedger = $this->appendLedgerEntry(TaskStatus::Failed);
        }
        $clone->status = TaskStatus::Failed;
        $clone->errorDetails = RedisSafeSerialization::sanitize($details);

        return $clone;
    }

    /**
     * @param  array<int, LedgerEntryDTO|array<string, mixed>>  $entries
     */
    public function withStatusLedger(array $entries): self
    {
        $clone = clone $this;
        $clone->statusLedger = array_map(
            static fn (LedgerEntryDTO|array $entry): LedgerEntryDTO => $entry instanceof LedgerEntryDTO ? $entry : LedgerEntryDTO::from($entry),
            $entries,
        );

        return $clone;
    }

    /**
     * Fusiona claves en {@see $vaultTransit} (sustitución superficial por clave).
     *
     * @param  array<string, mixed>  $patch
     */
    public function withVaultTransitPatch(array $patch): self
    {
        $clone = clone $this;
        $sanitizedPatch = RedisSafeSerialization::sanitize($patch);
        $clone->vaultTransit = array_replace($this->vaultTransit, is_array($sanitizedPatch) ? $sanitizedPatch : []);

        return $clone;
    }

    /**
     * @return array<int, LedgerEntryDTO>
     */
    private function appendLedgerEntry(TaskStatus $newStatus): array
    {
        $now = microtime(true);
        $ledger = $this->statusLedger;
        $durationMs = 0.0;
        if ($ledger !== []) {
            $lastKey = array_key_last($ledger);
            $lastEntry = $ledger[$lastKey];
            $prevTs = $lastEntry instanceof LedgerEntryDTO
                ? $lastEntry->timestamp
                : (float) ($lastEntry['timestamp'] ?? 0);
            if ($prevTs > 0) {
                $durationMs = round(($now - $prevTs) * 1000, 3);
            }
        }

        $ledger[] = new LedgerEntryDTO(
            status: self::statusToLedgerLabel($newStatus->value),
            timestamp: $now,
            duration_ms: $durationMs,
        );

        return $ledger;
    }

    /**
     * p. ej. processing → Processing, tool_execution → Tool_Execution, llm_executed → Llm_Executed
     */
    private static function statusToLedgerLabel(string $status): string
    {
        $parts = preg_split('/[_\s]+/', strtolower(trim($status)), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        return implode('_', array_map(
            static fn (string $part): string => ucfirst($part),
            $parts,
        ));
    }

    // ── Helpers de lectura ────────────────────────────────────────────────────

    public function hasFailed(): bool
    {
        return $this->status === TaskStatus::Failed;
    }

    public function totalTokensIn(): int
    {
        return (int) array_sum(array_map(
            static fn (WorkerResultDTO $entry): int => $entry->tokensIn,
            $this->telemetry,
        ));
    }

    public function totalTokensOut(): int
    {
        return (int) array_sum(array_map(
            static fn (WorkerResultDTO $entry): int => $entry->tokensOut,
            $this->telemetry,
        ));
    }
}
