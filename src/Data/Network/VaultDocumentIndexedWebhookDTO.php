<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentStatus;

/**
 * Payload HMAC-firmado hacia el Spoke cuando un documento de bóveda queda indexado.
 */
final class VaultDocumentIndexedWebhookDTO extends Data
{
    public function __construct(
        public readonly string $document_id,
        public readonly DocumentStatus $status,
    ) {}
}
