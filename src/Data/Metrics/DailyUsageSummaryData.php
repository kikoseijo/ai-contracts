<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Metrics;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class DailyUsageSummaryData extends Data
{
    public function __construct(
        public readonly string $tenant_id,
        public readonly CarbonImmutable $date,
        public readonly int $total_requests,
        public readonly int $total_tokens,
        public readonly float $total_cost_usd,
    ) {}
}
