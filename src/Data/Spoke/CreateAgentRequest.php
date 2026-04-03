<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\HandlerSlug;

class CreateAgentRequest extends Data
{
    /**
     * @param  array<string, mixed>|null  $config
     */
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, StringType, Max(255)]
        public readonly string $name,
        #[Required]
        public readonly HandlerSlug $handler_slug,
        public readonly ?array $config = null,
        #[Ulid]
        public readonly ?string $knowledge_vault_id = null,
        public readonly ?string $blueprint_id = null,
    ) {}
}
