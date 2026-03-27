<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extraction;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

/**
 * Extracción de nóminas: salarios, retenciones y cotizaciones.
 */
final class PayslipExtractionDTO extends Data
{
    public function __construct(
        #[Required]
        public readonly float $net_salary,

        #[Required]
        public readonly float $gross_salary,

        public readonly ?float $irpf_withholding = null,
        public readonly ?float $social_security_contributions = null,
        public readonly ?string $company_name = null,
        public readonly ?string $company_tax_id = null,
        public readonly ?string $employee_name = null,
        public readonly ?string $employee_tax_id = null,
        public readonly ?string $issue_date = null,
    ) {}
}
