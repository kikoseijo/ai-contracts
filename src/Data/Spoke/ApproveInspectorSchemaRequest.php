<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

class ApproveInspectorSchemaRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,

        #[Required]
        /** @var array<string, mixed> */
        public readonly array $discovered_schema,

        #[Required, In('dedicated', 'generic', 'webhook')]
        public readonly string $action_type,
    ) {}
}
