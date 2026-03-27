<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extraction;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentType;

/**
 * Extracción genérica: facturas, presupuestos, proformas, albaranes.
 */
final class InvoiceExtractionDTO extends Data
{
    public function __construct(
        #[Required]
        public readonly DocumentType $document_type,

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

        /** @var array<int, ExtractionLineItemDTO>|null */
        public readonly ?array $line_items = null,
    ) {}
}
