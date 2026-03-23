<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Attributes\Validation\Url;
use Spatie\LaravelData\Data;

class UpdateAgentRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Max(255)]
        public readonly string $name,
        #[Nullable, Url, Max(2048)]
        public readonly ?string $webhook_url = null,
        #[Nullable, Ulid]
        public readonly ?string $knowledge_vault_id = null,
        #[Nullable, StringType, Max(5000)]
        public readonly ?string $system_prompt = null,
    ) {}
}
