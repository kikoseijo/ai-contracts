<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Payload HMAC-firmado cuando el Hub descubre un nuevo esquema de documento.
 */
final class SchemaDiscoveredWebhookDTO extends Data
{
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly string $tenant_id,
        public readonly string $new_document_name,
        public readonly string $schema_slug,
    ) {}
}
