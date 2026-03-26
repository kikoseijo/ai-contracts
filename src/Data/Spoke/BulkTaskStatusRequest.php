<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class BulkTaskStatusRequest extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $ids,
    ) {}

    /**
     * @return array<int, string>
     */
    public function getIdsArray(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $this->ids))));
    }
}
