<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extraction\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Sunnyface\Contracts\Data\Extraction\InvoiceExtractionDTO;
use Sunnyface\Contracts\Data\Extraction\PayslipExtractionDTO;
use Sunnyface\Contracts\Data\Extraction\ReceiptExtractionDTO;

class FinancialExtractionPolymorphicCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        $schema = $properties['detected_schema'] ?? null;

        return match ($schema) {
            'invoice', 'quote', 'proforma', 'delivery_note' => InvoiceExtractionDTO::from($value),
            'receipt' => ReceiptExtractionDTO::from($value),
            'payslip' => PayslipExtractionDTO::from($value),
            default => throw new \InvalidArgumentException("Unknown extraction schema: {$schema}"),
        };
    }
}
