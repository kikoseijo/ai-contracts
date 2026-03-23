<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

final class TenantTaskUsageWebhookDTO extends Data
{
    public function __construct(
        public readonly int $total_tokens,
        public readonly float $total_cost,
    ) {}
}
