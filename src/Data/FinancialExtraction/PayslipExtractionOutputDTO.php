<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\FinancialExtraction;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class PayslipExtractionOutputDTO extends Data
{
    public function __construct(
        #[UI(label: 'Company Name', component: UiComponent::Text)]
        public readonly ?string $company_name,

        #[UI(label: 'Company Tax ID (RSIN/KVK)', component: UiComponent::Text)]
        public readonly ?string $company_tax_id,

        #[UI(label: 'Employee Name', component: UiComponent::Text)]
        public readonly ?string $employee_name,

        #[UI(label: 'Employee Tax ID (BSN)', component: UiComponent::Text)]
        public readonly ?string $employee_tax_id,

        #[UI(label: 'Fiscal Year / Period', component: UiComponent::Text)]
        public readonly ?string $fiscal_period,

        #[UI(label: 'Gross Salary (Loon loonheffing)', component: UiComponent::Number)]
        public readonly float $gross_salary,

        #[UI(label: 'Net Salary (Netto loon)', component: UiComponent::Number)]
        public readonly float $net_salary,

        #[UI(label: 'Withheld Tax (Ingehouden loonbelasting)', component: UiComponent::Number)]
        public readonly float $withheld_tax,

        #[UI(label: 'Health Insurance Act (Bijdrage Zvw)', component: UiComponent::Number)]
        public readonly ?float $health_insurance_contribution = null,

        #[UI(label: 'Labor Tax Credit (Arbeidskorting)', component: UiComponent::Number)]
        public readonly ?float $labor_tax_credit = null,

        #[UI(label: 'Holiday Allowance (Vakantiegeld)', component: UiComponent::Number)]
        public readonly ?float $holiday_allowance = null,

        #[UI(label: 'Confidence (0-100)', component: UiComponent::Number)]
        public readonly int $confidence_score,

        #[UI(label: 'AI Notes', component: UiComponent::Textarea)]
        public readonly ?string $ai_notes = null,
    ) {}
}
