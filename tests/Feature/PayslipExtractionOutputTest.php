<?php

use Sunnyface\Contracts\Data\FinancialExtraction\PayslipExtractionOutputDTO;

it('hydrates a Dutch payslip with all fields', function () {
    $dto = PayslipExtractionOutputDTO::from([
        'company_name' => 'Sunnyface B.V.',
        'company_tax_id' => 'NL123456789B01',
        'employee_name' => 'Jan de Vries',
        'employee_tax_id' => '123456789',
        'fiscal_period' => '2026-03',
        'gross_salary' => 4200.00,
        'net_salary' => 2850.00,
        'withheld_tax' => 980.00,
        'health_insurance_contribution' => 220.50,
        'labor_tax_credit' => 315.00,
        'holiday_allowance' => 336.00,
        'confidence_score' => 92,
        'ai_notes' => 'Extracted from Jaarloonstaat 2026',
    ]);

    expect($dto->gross_salary)->toBe(4200.00)
        ->and($dto->net_salary)->toBe(2850.00)
        ->and($dto->withheld_tax)->toBe(980.00)
        ->and($dto->health_insurance_contribution)->toBe(220.50)
        ->and($dto->company_name)->toBe('Sunnyface B.V.');
});

it('accepts minimal payslip with only required fields', function () {
    $dto = PayslipExtractionOutputDTO::from([
        'gross_salary' => 3500.00,
        'net_salary' => 2400.00,
        'withheld_tax' => 750.00,
        'confidence_score' => 78,
    ]);

    expect($dto->company_name)->toBeNull()
        ->and($dto->holiday_allowance)->toBeNull()
        ->and($dto->confidence_score)->toBe(78);
});
