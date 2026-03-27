<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum DocumentType: string
{
    case Invoice = 'invoice';
    case Quote = 'quote';
    case Proforma = 'proforma';
    case DeliveryNote = 'delivery_note';
}
