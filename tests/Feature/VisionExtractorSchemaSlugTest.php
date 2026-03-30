<?php

declare(strict_types=1);

use Sunnyface\Contracts\Data\FinancialExtraction\FinancialExtractionOutputDTO;
use Sunnyface\Contracts\Data\FinancialExtraction\PayslipExtractionOutputDTO;
use Sunnyface\Contracts\Enums\VisionExtractorSchemaSlug;

test('cada caso apunta al DTO de salida del contrato', function (): void {
    expect(VisionExtractorSchemaSlug::FinancialDocument->outputDtoClass())
        ->toBe(FinancialExtractionOutputDTO::class)
        ->and(VisionExtractorSchemaSlug::Payslip->outputDtoClass())
        ->toBe(PayslipExtractionOutputDTO::class);
});

test('outputDtoClassForSlug resuelve por string wire y devuelve null si no es canónico', function (): void {
    expect(VisionExtractorSchemaSlug::outputDtoClassForSlug('financial-document'))
        ->toBe(FinancialExtractionOutputDTO::class)
        ->and(VisionExtractorSchemaSlug::outputDtoClassForSlug('payslip'))
        ->toBe(PayslipExtractionOutputDTO::class)
        ->and(VisionExtractorSchemaSlug::outputDtoClassForSlug('custom-dynamic'))
        ->toBeNull()
        ->and(VisionExtractorSchemaSlug::outputDtoClassForSlug(null))
        ->toBeNull()
        ->and(VisionExtractorSchemaSlug::outputDtoClassForSlug(''))
        ->toBeNull();
});

test('missingMetadataSchemaSlugMessage describe el contrato metadata.schema_slug', function (): void {
    expect(VisionExtractorSchemaSlug::missingMetadataSchemaSlugMessage())
        ->toBe("schema_slug desconocido o ausente: ''. El Hub debe enviar metadata.schema_slug con un valor del enum VisionExtractorSchemaSlug.")
        ->and(VisionExtractorSchemaSlug::missingMetadataSchemaSlugMessage('foo'))
        ->toBe("schema_slug desconocido o ausente: 'foo'. El Hub debe enviar metadata.schema_slug con un valor del enum VisionExtractorSchemaSlug.");
});
