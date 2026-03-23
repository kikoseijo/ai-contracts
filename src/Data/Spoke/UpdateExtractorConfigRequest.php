<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Attributes\Validation\Url;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\ExtractorTemplate;

class UpdateExtractorConfigRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,

        #[Required]
        public readonly ExtractorTemplate $extractor_template,

        public readonly bool $strict_mode = false,

        public readonly bool $store_in_vault = false,

        #[Nullable, Max(26)]
        public readonly ?string $knowledge_vault_id = null,

        #[Nullable, Max(255)]
        public readonly ?string $fallback_email = null,

        public readonly bool $email_only_on_error = false,

        #[Nullable, Url, Max(2048)]
        public readonly ?string $webhook_url = null,
    ) {}
}
