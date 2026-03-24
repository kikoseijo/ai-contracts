<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\TaskStatus;

final class TenantTaskCompletedPayloadWebhookDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
        public readonly string $tenant_id,
        public readonly string $tenant_agent_id,
        public readonly TaskStatus $status,
        public readonly TenantTaskUsageWebhookDTO $usage,
        public readonly string $completed_at,
    ) {}
}
