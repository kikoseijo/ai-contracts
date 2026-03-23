<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Payload que el Hub envía con el consumo de IA tras procesar una tarea.
 */
final class UsageWebhookDTO extends Data
{
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly string $tenant_id,
        public readonly float $cost_applied,
        public readonly ?string $usage_log_id = null,
        public readonly int $prompt_tokens = 0,
        public readonly int $completion_tokens = 0,
    ) {}
}
