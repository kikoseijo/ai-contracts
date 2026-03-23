<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Metrics;

use Spatie\LaravelData\Data;

class MonthlyBillingSummaryData extends Data
{
    public function __construct(
        public readonly string $tenant_id,
        public readonly string $billing_month,
        public readonly int $total_requests,
        public readonly int $total_tokens,
        public readonly float $total_cost_usd,
    ) {}
}
