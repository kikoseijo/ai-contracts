<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extraction;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

/**
 * Extracción de tickets/recibos de gastos rápidos.
 */
final class ReceiptExtractionDTO extends Data
{
    public function __construct(
        #[Required]
        public readonly float $total_amount,

        public readonly ?string $vendor_name = null,
        public readonly ?string $issue_date = null,
        public readonly ?float $tax_included = null,
    ) {}
}
