<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum ExtractionSchema: string
{
    case Invoice = 'invoice';
    case Receipt = 'receipt';
    case Payslip = 'payslip';
    case Quote = 'quote';
    case Proforma = 'proforma';
    case DeliveryNote = 'delivery_note';
}
