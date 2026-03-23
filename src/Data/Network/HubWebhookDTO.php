<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\TaskStatus;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Envelope genérico Hub → Spoke para webhooks de **tareas** (`task.*`).
 *
 * `status` es **siempre** {@see TaskStatus}: refleja el estado del ciclo de vida de la tarea.
 * Para documentos / extracción usar {@see ExtractionHubWebhookDTO} (`DocumentStatus`).
 * No uses `string` para estado en ningún webhook compartido: los satélites hidratan con enums.
 *
 * @param  array<string, mixed>|null  $output
 * @param  array<string, mixed>|null  $metadata
 */
final class HubWebhookDTO extends Data
{
    /**
     * @param  array<string, mixed>|null  $output
     * @param  array<string, mixed>|null  $metadata
     */
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly string $tenant_id,
        public readonly TaskStatus $status,
        public readonly ?string $task_id = null,
        public readonly ?string $document_id = null,
        public readonly ?array $output = null,
        public readonly ?string $error = null,
        public readonly ?array $metadata = null,
    ) {}
}
