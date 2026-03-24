<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

final class SpokeToolDefinitionDTO extends Data
{
    public function __construct(
        #[Required]
        public readonly string $name,
        #[Required]
        public readonly string $description,
        #[Required]
        public readonly array $parameters,
    ) {}
}
