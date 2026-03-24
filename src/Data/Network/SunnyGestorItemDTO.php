<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

final class SunnyGestorItemDTO extends Data
{
    public function __construct(
        public readonly string $description,
        public readonly float $quantity,
        public readonly float $price,
        public readonly float $tax_rate,
    ) {}
}
