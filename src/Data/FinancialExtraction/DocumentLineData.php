<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\FinancialExtraction;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class DocumentLineData extends Data
{
    public function __construct(
        #[UI(label: 'Description', component: UiComponent::Text)]
        public readonly string $description,

        #[UI(label: 'Quantity', component: UiComponent::Number)]
        public readonly float $quantity,

        #[UI(label: 'Unit Price', component: UiComponent::Number)]
        public readonly float $unit_price,

        #[UI(label: 'Line Total', component: UiComponent::Number)]
        public readonly float $line_total,

        #[UI(label: 'Tax Rate (%)', component: UiComponent::Number)]
        public readonly ?float $tax_rate = null,
    ) {}
}
