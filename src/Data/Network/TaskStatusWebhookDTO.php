<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Spoke\Responses\ChatMessageDTO;
use Sunnyface\Contracts\Enums\TaskStatus;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Payload canónico que el Hub envía a los clientes externos (vía AgentWebhook)
 * cuando una tarea cambia de estado.
 *
 * Sustituye CUALQUIER array construido inline antes de Http::post().
 * El Spoke debe deserializar este DTO para consumir el resultado.
 *
 * @param  array<string, mixed>|null  $output_payload  Resultado del agente; null si la tarea falló o está en curso.
 * @param  array<string, mixed>  $metadata  Métricas de uso (tokens_in, tokens_out, cost_usd).
 */
final class TaskStatusWebhookDTO extends Data
{
    /**
     * @param  array<string, mixed>|null  $output_payload
     * @param  array<string, mixed>  $metadata
     * @param  array<int, \Sunnyface\Contracts\Data\Spoke\Responses\ChatMessageDTO>|null  $messages_history
     * @param  array<string, mixed>|null  $telemetry_snapshot
     */
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly string $tenant_id,
        public readonly string $agent_id,
        public readonly string $task_id,
        public readonly TaskStatus $status,
        public readonly ?array $output_payload = null,
        public readonly array $metadata = [],
        #[DataCollectionOf(ChatMessageDTO::class)]
        public readonly ?array $messages_history = null,
        public readonly ?array $telemetry_snapshot = null,
    ) {}
}
