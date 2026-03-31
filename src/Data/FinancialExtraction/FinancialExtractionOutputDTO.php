<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\FinancialExtraction;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class FinancialExtractionOutputDTO extends Data
{
    /**
     * @param  DocumentLineData[]  $line_items
     */
    public function __construct(
        #[UI(label: 'Document Type', component: UiComponent::Select, options: ['invoice' => 'Invoice', 'receipt' => 'Receipt', 'quote' => 'Quote', 'credit_note' => 'Credit Note'])]
        public readonly string $document_type,

        #[UI(label: 'Document Number', component: UiComponent::Text)]
        public readonly ?string $document_number,

        #[UI(label: 'Issue Date', component: UiComponent::Date)]
        public readonly ?string $issue_date,

        #[UI(label: 'Due Date', component: UiComponent::Date)]
        public readonly ?string $due_date,

        #[UI(label: 'Vendor Name', component: UiComponent::Text)]
        public readonly ?string $vendor_name,

        #[UI(label: 'Vendor Tax ID', component: UiComponent::Text)]
        public readonly ?string $vendor_tax_id,

        #[UI(label: 'Client Name (Inferred)', component: UiComponent::Text)]
        public readonly ?string $client_name,

        #[UI(label: 'Client Tax ID (Inferred)', component: UiComponent::Text)]
        public readonly ?string $client_tax_id,

        #[UI(label: 'Currency', component: UiComponent::Text)]
        public readonly string $currency,

        #[UI(label: 'Subtotal', component: UiComponent::Number)]
        public readonly float $subtotal,

        #[UI(label: 'Tax Amount', component: UiComponent::Number)]
        public readonly float $tax_amount,

        #[UI(label: 'Total', component: UiComponent::Number)]
        public readonly float $total,

        #[UI(label: 'Retention Amount', component: UiComponent::Number)]
        /** Importe retenido (ej. IRPF en España). Si no hay retención, es 0. */
        public readonly float $retention_amount = 0.0,

        #[UI(label: 'Retention Rate', component: UiComponent::Number)]
        /** Porcentaje de la retención (ej. 7 o 15). Si no hay, es 0. */
        public readonly float $retention_rate = 0.0,

        #[UI(label: 'Line Items', component: UiComponent::Table)]
        /** @var array<int, DocumentLineData>|null */
        public readonly ?array $line_items = null,

        #[UI(label: 'Confidence (0-100)', component: UiComponent::Number)]
        public readonly int $confidence_score,

        #[UI(label: 'AI Notes', component: UiComponent::Textarea)]
        public readonly ?string $ai_notes = null,
    ) {}
}
