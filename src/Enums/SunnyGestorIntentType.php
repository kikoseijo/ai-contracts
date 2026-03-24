<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum SunnyGestorIntentType: string
{
    case InvoiceGeneration = 'invoice_generation';
    case ExpenseExtraction = 'expense_extraction';
    case EstimateGeneration = 'estimate_generation';
    case GeneralQuery = 'general_query';
}
