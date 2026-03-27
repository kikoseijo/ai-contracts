<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\InsightSeverity;
use Sunnyface\Contracts\Enums\InsightType;
use Sunnyface\Contracts\Enums\WebhookEvent;

/**
 * Payload que el Hub envía cuando se genera un insight de governance (AIOps).
 */
final class GovernanceInsightWebhookDTO extends Data
{
    /**
     * @param  array<string, mixed>|null  $context_data
     */
    public function __construct(
        public readonly WebhookEvent $event,
        public readonly string $tenant_id,
        public readonly string $tenant_agent_id,
        public readonly InsightType $type,
        public readonly InsightSeverity $severity,
        public readonly string $message,
        public readonly ?array $context_data = null,
    ) {}
}
