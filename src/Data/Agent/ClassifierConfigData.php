<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Agent;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\ClassifierPriority;

class ClassifierConfigData extends Data
{
    /**
     * @param  array<int, string>  $allowed_categories
     */
    public function __construct(
        #[Required]
        public readonly array $allowed_categories,
        public readonly ClassifierPriority $default_priority = ClassifierPriority::Normal,
    ) {}
}
