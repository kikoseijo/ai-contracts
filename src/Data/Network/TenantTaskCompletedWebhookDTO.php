<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Sobre canónico para el webhook de tenant externo al completar tarea.
 */
final class TenantTaskCompletedWebhookDTO extends Data
{
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly TenantTaskCompletedPayloadWebhookDTO $data,
    ) {}
}
