<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extraction;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

/**
 * Extracción genérica: facturas, presupuestos, proformas, albaranes.
 */
final class InvoiceExtractionDTO extends Data
{
    public function __construct(
        #[Required]
        public readonly string $document_type, // 'invoice', 'quote', 'proforma', 'delivery_note'

        #[Required]
        public readonly float $total_amount,

        public readonly ?float $subtotal = null,
        public readonly ?float $tax_amount = null,
        public readonly ?string $issuer_name = null,
        public readonly ?string $issuer_tax_id = null,
        public readonly ?string $receiver_name = null,
        public readonly ?string $receiver_tax_id = null,
        public readonly ?string $issue_date = null,
        public readonly ?string $reference_number = null,

        /** @var array<int, mixed>|null */
        public readonly ?array $line_items = null,
    ) {}
}
