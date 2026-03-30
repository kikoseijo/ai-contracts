<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\FinancialExtraction\FinancialExtractionOutputDTO;
use Sunnyface\Contracts\Data\FinancialExtraction\PayslipExtractionOutputDTO;

/**
 * Slugs de esquema de salida del vision-extractor definidos en contrato.
 * El Hub envía {@see $value} en `schema_slug`; el satélite puede resolver
 * {@see self::outputDtoClass()} para hidratar el JSON con Spatie Data.
 */
enum VisionExtractorSchemaSlug: string
{
    case FinancialDocument = 'financial-document';
    case Payslip = 'payslip';

    /**
     * @return class-string<Data>
     */
    public function outputDtoClass(): string
    {
        return match ($this) {
            self::FinancialDocument => FinancialExtractionOutputDTO::class,
            self::Payslip => PayslipExtractionOutputDTO::class,
        };
    }

    public function label(): string
    {
        return trans("ai-contracts::enums.vision_extractor_schemas.{$this->value}.label");
    }

    public function description(): string
    {
        return trans("ai-contracts::enums.vision_extractor_schemas.{$this->value}.description");
    }

    /**
     * @return class-string<Data>|null
     */
    public static function outputDtoClassForSlug(?string $slug): ?string
    {
        if ($slug === null || $slug === '') {
            return null;
        }

        $case = self::tryFrom($slug);

        return $case?->outputDtoClass();
    }

    /**
     * Mensaje orientativo para el satélite (p. ej. campo `extraction_error`) cuando
     * `metadata.schema_slug` falta o no coincide con un caso de este enum.
     */
    public static function missingMetadataSchemaSlugMessage(?string $received = null): string
    {
        $shown = ($received === null || $received === '') ? "''" : "'{$received}'";

        return "schema_slug desconocido o ausente: {$shown}. El Hub debe enviar metadata.schema_slug con un valor del enum VisionExtractorSchemaSlug.";
    }
}
