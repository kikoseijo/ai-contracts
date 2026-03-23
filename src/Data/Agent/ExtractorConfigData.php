<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Agent;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\ExtractorTemplate;

class ExtractorConfigData extends Data
{
    public function __construct(
        public readonly ExtractorTemplate $extractor_template = ExtractorTemplate::Generic,
        #[BooleanType]
        public readonly bool $strict_mode = false,
        #[BooleanType]
        public readonly bool $fallback_to_human = false,
        #[BooleanType]
        public readonly bool $store_in_vault = false,
        #[Nullable, Email, Max(255)]
        public readonly ?string $fallback_email = null,
        #[BooleanType]
        public readonly bool $email_only_on_error = false,
    ) {}
}
