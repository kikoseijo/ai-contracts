<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Translator;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class TranslatorOutputDTO extends Data
{
    /**
     * @param  string|array<int, string>  $translated_content
     */
    public function __construct(
        #[UI(label: 'Translated Content', component: UiComponent::Textarea)]
        public readonly string|array $translated_content,

        #[UI(label: 'Detected Source Language', component: UiComponent::Text)]
        public readonly string $detected_source_language,

        #[UI(label: 'Confidence Score', component: UiComponent::Text)]
        public readonly float $confidence_score,
    ) {}
}
