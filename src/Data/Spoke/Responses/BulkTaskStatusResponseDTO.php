<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

final class BulkTaskStatusResponseDTO extends Data
{
    public function __construct(
        /** @var array<int, TaskStatusItemDTO>|null */
        public readonly ?array $tasks = null,
    ) {}

}
