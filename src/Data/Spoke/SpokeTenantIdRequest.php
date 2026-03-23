<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

class SpokeTenantIdRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
    ) {}
}
