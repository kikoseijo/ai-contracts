<?php

use Sunnyface\Contracts\Data\Extraction\InvoiceExtractionDTO;
use Sunnyface\Contracts\Data\Extraction\PayslipExtractionDTO;
use Sunnyface\Contracts\Data\Extraction\ReceiptExtractionDTO;
use Sunnyface\Contracts\Data\Extraction\StructuredExtractionResponseDTO;
use Sunnyface\Contracts\Enums\DocumentType;
use Sunnyface\Contracts\Enums\ExtractionSchema;

it('casts extracted_data to InvoiceExtractionDTO when detected_schema is invoice', function () {
    $dto = StructuredExtractionResponseDTO::from([
        'hub_task_id' => 'task-abc-123',
        'detected_schema' => 'invoice',
        'extracted_data' => [
            'document_type' => 'invoice',
            'total_amount' => 1210.00,
            'subtotal' => 1000.00,
            'tax_amount' => 210.00,
            'issuer_name' => 'Acme Corp',
            'issuer_tax_id' => 'B12345678',
        ],
    ]);

    expect($dto->detected_schema)->toBe(ExtractionSchema::Invoice)
        ->and($dto->extracted_data)->toBeInstanceOf(InvoiceExtractionDTO::class)
        ->and($dto->extracted_data->document_type)->toBe(DocumentType::Invoice)
        ->and($dto->extracted_data->total_amount)->toBe(1210.00)
        ->and($dto->extracted_data->issuer_name)->toBe('Acme Corp');
});

it('casts extracted_data to ReceiptExtractionDTO when detected_schema is receipt', function () {
    $dto = StructuredExtractionResponseDTO::from([
        'hub_task_id' => 'task-abc-456',
        'detected_schema' => 'receipt',
        'extracted_data' => [
            'total_amount' => 42.50,
            'vendor_name' => 'Café Central',
            'tax_included' => 3.69,
        ],
    ]);

    expect($dto->detected_schema)->toBe(ExtractionSchema::Receipt)
        ->and($dto->extracted_data)->toBeInstanceOf(ReceiptExtractionDTO::class)
        ->and($dto->extracted_data->vendor_name)->toBe('Café Central');
});

it('casts extracted_data to PayslipExtractionDTO when detected_schema is payslip', function () {
    $dto = StructuredExtractionResponseDTO::from([
        'hub_task_id' => 'task-abc-789',
        'detected_schema' => 'payslip',
        'extracted_data' => [
            'net_salary' => 2100.00,
            'gross_salary' => 2800.00,
            'irpf_withholding' => 420.00,
            'social_security_contributions' => 177.80,
            'company_name' => 'Sunnyface SL',
        ],
    ]);

    expect($dto->detected_schema)->toBe(ExtractionSchema::Payslip)
        ->and($dto->extracted_data)->toBeInstanceOf(PayslipExtractionDTO::class)
        ->and($dto->extracted_data->gross_salary)->toBe(2800.00)
        ->and($dto->extracted_data->company_name)->toBe('Sunnyface SL');
});

it('throws on unknown detected_schema', function () {
    StructuredExtractionResponseDTO::from([
        'hub_task_id' => 'task-abc-000',
        'detected_schema' => 'alien_document',
        'extracted_data' => ['foo' => 'bar'],
    ]);
})->throws(\Spatie\LaravelData\Exceptions\CannotCastEnum::class);
