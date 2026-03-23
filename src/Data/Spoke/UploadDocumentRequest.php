<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

class UploadDocumentRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Ulid]
        public readonly string $vault_id,
        #[Required, StringType]
        public readonly string $file_path,
        #[Nullable]
        public readonly ?string $name = null,
        #[Nullable]
        public readonly ?string $description = null,
    ) {}
}
