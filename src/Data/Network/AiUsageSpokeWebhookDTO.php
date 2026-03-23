<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Consumo de IA notificado al Spoke para descuento de cartera (billing).
 */
final class AiUsageSpokeWebhookDTO extends Data
{
    public function __construct(
        public readonly string $tenant_id,
        public readonly int $usage_log_id,
        public readonly int $prompt_tokens,
        public readonly int $completion_tokens,
        public readonly float $cost_applied,
    ) {}
}
