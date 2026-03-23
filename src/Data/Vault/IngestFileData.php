<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Vault;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class IngestFileData extends Data
{
    public function __construct(
        #[UI(label: 'Documento', component: UiComponent::File)]
        public readonly mixed $file,

        #[UI(label: 'Título (Opcional)', component: UiComponent::Input)]
        public readonly ?string $title = null,
    ) {}
}
