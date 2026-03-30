<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Llm;

use Spatie\LaravelData\Data;
use Sunnyface\AiContracts\Support\DeepCloneable;
use Sunnyface\Contracts\Enums\PipeName;

/**
 * Resultado inmediato de un Pipe individual.
 *
 * Es el objeto ligero que cada Pipe devuelve antes de que el pipeline principal
 * lo fusione en el CognitiveContextDTO maestro via recordTelemetry().
 *
 * Inmutabilidad asimétrica (PHP 8.4): public private(set).
 * El TelemetryPipeMiddleware lo completa con duration_ms antes de la fusión.
 */
final class WorkerResultDTO extends Data
{
    use DeepCloneable;

    public function __construct(
        /** Pipe que generó este resultado. Soporta Enums core o strings de pipes dinámicos del Spoke. */
        public private(set) PipeName|string $pipeName,

        /** Respuesta cruda del LLM (JSON, texto plano, o null si el Pipe no llama al LLM). */
        public private(set) ?string $rawLlmResponse = null,

        /** Tokens consumidos en el prompt de esta llamada LLM. */
        public private(set) int $tokensIn = 0,

        /** Tokens generados en la respuesta de esta llamada LLM. */
        public private(set) int $tokensOut = 0,

        /** Modelo LLM utilizado en este step (ej. 'gpt-4o', 'claude-sonnet-4-6'). */
        public private(set) string $model = '',

        /**
         * Duración de ejecución del Pipe en milisegundos.
         * Inyectado por TelemetryPipeMiddleware, no por el Pipe mismo.
         */
        public private(set) float $durationMs = 0.0,

        /** Mensaje de error si el Pipe falló, null si fue exitoso. */
        public private(set) ?string $errorMessage = null,
    ) {}

    /**
     * Devuelve una copia con el tiempo de ejecución registrado.
     * Lo llama TelemetryPipeMiddleware tras la ejecución del Pipe.
     */
    public function withDuration(float $durationMs): self
    {
        $clone = clone $this;
        $clone->durationMs = $durationMs;

        return $clone;
    }

    public function hasError(): bool
    {
        return $this->errorMessage !== null;
    }

    public function totalTokens(): int
    {
        return $this->tokensIn + $this->tokensOut;
    }

    /**
     * Helper para garantizar la serialización segura a DB/Redis.
     */
    public function getPipeNameString(): string
    {
        return $this->pipeName instanceof PipeName
            ? $this->pipeName->value
            : $this->pipeName;
    }
}
