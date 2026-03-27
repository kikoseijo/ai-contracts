<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentStatus;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Payload canónico que el Hub envía al Spoke cuando un documento de bóveda
 * cambia de estado. Solo incluye los campos mínimos para mantener el payload
 * pequeño y la firma HMAC predecible.
 */
final class VaultDocumentWebhookDTO extends Data
{
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly string $document_id,
        public readonly DocumentStatus $status,
    ) {}
}
