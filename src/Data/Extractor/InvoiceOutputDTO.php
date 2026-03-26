<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extractor;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Data\FinancialExtraction\DocumentLineData;
use Sunnyface\Contracts\Enums\UiComponent;

class InvoiceOutputDTO extends Data
{
    public function __construct(
        #[UI(label: 'Vendor Name', component: UiComponent::Text)]
        public readonly ?string $vendor_name = null,

        #[UI(label: 'Invoice Number', component: UiComponent::Text)]
        public readonly ?string $invoice_number = null,

        #[UI(label: 'Issue Date', component: UiComponent::Text)]
        public readonly ?string $issue_date = null,

        #[UI(label: 'Total Amount', component: UiComponent::Text)]
        public readonly ?float $total_amount = null,

        #[UI(label: 'Currency', component: UiComponent::Text)]
        public readonly ?string $currency = null,

        #[UI(label: 'Line Items', component: UiComponent::Repeater)]
        #[DataCollectionOf(DocumentLineData::class)]
        public readonly ?DataCollection $line_items = null,
    ) {}
}
