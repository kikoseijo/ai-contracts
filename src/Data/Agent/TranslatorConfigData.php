<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Agent;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class TranslatorConfigData extends Data
{
    public function __construct(
        #[Required, StringType, Max(100)]
        public readonly string $target_language,
        #[Nullable, StringType]
        public readonly ?string $forbidden_words = null,
        #[Nullable, StringType]
        public readonly ?string $tone_guidelines = null,
    ) {}
}
