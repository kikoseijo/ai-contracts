<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extraction;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

/**
 * Línea individual de un documento financiero extraído.
 */
final class ExtractionLineItemDTO extends Data
{
    public function __construct(
        #[Required]
        public readonly string $description,

        #[Required]
        public readonly float $quantity,

        #[Required]
        public readonly float $unit_price,

        #[Required]
        public readonly float $line_total,

        public readonly ?float $tax_rate = null,
    ) {}
}
