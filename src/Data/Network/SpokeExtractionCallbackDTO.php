<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Callback Spoke -> Hub tras completar el pipeline de extraccion local.
 *
 * El Spoke envia este DTO al Hub con el resultado final de la extraccion,
 * incluyendo el trace_id para correlacion end-to-end.
 */
final class SpokeExtractionCallbackDTO extends Data
{
    /**
     * @param  array<string, mixed>  $extracted_data
     * @param  list<string>  $validation_errors
     */
    public function __construct(
        public readonly string $trace_id,
        public readonly string $tenant_id,
        public readonly string $document_id,
        public readonly string $status,
        public readonly array $extracted_data = [],
        public readonly array $validation_errors = [],
        public readonly ?string $audit_risk_note = null,
    ) {}
}
