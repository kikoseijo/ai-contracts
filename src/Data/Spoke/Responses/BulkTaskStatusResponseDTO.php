<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Data;

final class BulkTaskStatusResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(TaskStatusItemDTO::class)]
        public readonly DataCollection $tasks,
    ) {}

}
