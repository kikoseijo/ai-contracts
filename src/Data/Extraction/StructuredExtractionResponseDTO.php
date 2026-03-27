<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extraction;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Extraction\Casts\FinancialExtractionPolymorphicCast;
use Sunnyface\Contracts\Enums\ExtractionSchema;

/**
 * Envoltorio de red: el Satélite recibe este DTO con extracted_data
 * hidratado polimórficamente según detected_schema.
 */
final class StructuredExtractionResponseDTO extends Data
{
    public function __construct(
        #[Required]
        public readonly string $hub_task_id,

        #[Required]
        public readonly ExtractionSchema $detected_schema,

        #[Required]
        #[WithCast(FinancialExtractionPolymorphicCast::class)]
        public readonly InvoiceExtractionDTO|ReceiptExtractionDTO|PayslipExtractionDTO $extracted_data,

        /** @var array<string, mixed>|null */
        public readonly ?array $confidence_metrics = null,
    ) {}
}
