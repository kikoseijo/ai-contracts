<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;

final class SunnyGestorExtractedDataDTO extends Data
{
    /**
     * @param SunnyGestorItemDTO[] $items
     */
    public function __construct(
        public readonly ?string $client_tax_id,
        public readonly ?string $client_name,
        public readonly ?CarbonImmutable $issue_date,
        public readonly float $total_amount,
        public readonly float $tax_amount,
        #[DataCollectionOf(SunnyGestorItemDTO::class)]
        public readonly array $items = [],
    ) {}
}
