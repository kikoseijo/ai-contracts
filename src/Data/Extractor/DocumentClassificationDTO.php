<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extractor;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;
use Sunnyface\Contracts\Enums\VaultDocumentType;

class DocumentClassificationDTO extends Data
{
    public function __construct(
        #[UI(label: 'Tipo de Documento', component: UiComponent::Badge)]
        public readonly VaultDocumentType $document_type,

        #[UI(label: 'Confianza', hidden: true)]
        public readonly float $confidence_score,

        #[UI(label: 'Idioma', hidden: true)]
        public readonly ?string $language,

        #[UI(label: 'Resumen', component: UiComponent::Textarea)]
        public readonly ?string $summary,
    ) {}
}
