<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentStatus;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Envelope Hub → Spoke para webhooks de extracción de documentos.
 * Tipado estrictamente con DocumentStatus; nunca usar HubWebhookDTO para eventos de extracción.
 *
 * @param  array<string, mixed>|null  $output
 * @param  array<string, mixed>|null  $metadata
 */
final class ExtractionHubWebhookDTO extends Data
{
    /**
     * @param  array<string, mixed>|null  $output
     * @param  array<string, mixed>|null  $metadata
     */
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly string $tenant_id,
        public readonly DocumentStatus $status,
        public readonly ?string $document_id = null,
        public readonly ?array $output = null,
        public readonly ?string $error = null,
        public readonly ?array $metadata = null,
    ) {}
}
