<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

final class BulkTaskStatusResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(TaskStatusItemDTO::class)]
        public readonly ?DataCollection $tasks = null,
    ) {}

}
