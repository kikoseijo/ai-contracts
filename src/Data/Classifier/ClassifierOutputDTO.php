<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Classifier;

use Sunnyface\Contracts\Data\Spoke\Payloads\BaseOutputPayloadData;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class ClassifierOutputDTO extends BaseOutputPayloadData
{
    public function __construct(
        #[UI(label: 'Category', component: UiComponent::Text)]
        public readonly string $category,

        #[UI(label: 'Priority', component: UiComponent::Text)]
        public readonly string $priority,

        #[UI(label: 'Summary', component: UiComponent::Textarea)]
        public readonly string $summary,

        #[UI(label: 'Confidence Score', component: UiComponent::Text)]
        public readonly float $confidence_score,
    ) {}
}
