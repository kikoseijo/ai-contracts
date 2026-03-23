<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Agent;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

class TalkerConfigData extends Data
{
    public function __construct(
        #[Nullable, Ulid]
        public readonly ?string $blueprint_id = null,
        #[Nullable, StringType, Max(255)]
        public readonly ?string $name = null,
        #[Nullable, StringType, Max(255)]
        public readonly ?string $public_name = null,
        #[Nullable, StringType]
        public readonly ?string $user_base_prompt = null,
        #[Nullable, StringType]
        public readonly ?string $user_rules_prompt = null,
        #[Nullable, StringType, Max(500)]
        public readonly ?string $greeting = null,
    ) {}
}
