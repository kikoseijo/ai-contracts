<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\TaskStatus;

final class WidgetTaskStatusResponseDTO extends Data
{
    public function __construct(
        public readonly TaskStatus $status,
        #[DataCollectionOf(ChatMessageDTO::class)]
        public readonly DataCollection $messages,
    ) {}

}
