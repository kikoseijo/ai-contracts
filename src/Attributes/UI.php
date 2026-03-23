<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Attributes;

use Attribute;
use Sunnyface\Contracts\Enums\UiComponent;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UI
{
    /**
     * @param  array<string, string>|null  $options
     */
    public function __construct(
        public string $label,
        public UiComponent $component = UiComponent::Text,
        public string $placeholder = '',
        public ?array $options = null,
        public bool $hidden = false,
        public string $description = '',
    ) {}
}
