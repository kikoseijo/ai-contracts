<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Payload que el Hub envía cuando cambia el saldo de tokens de un tenant.
 */
final class QuotaUpdatedWebhookDTO extends Data
{
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly string $tenant_id,
        public readonly int $available_tokens,
    ) {}
}
