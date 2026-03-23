<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Vault;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class IngestTextData extends Data
{
    public function __construct(
        #[UI(label: 'Título', component: UiComponent::Input)]
        public readonly string $title,

        #[UI(label: 'Contenido', component: UiComponent::Textarea)]
        public readonly string $content,
    ) {}
}
