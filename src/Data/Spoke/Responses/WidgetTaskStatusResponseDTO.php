<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\TaskStatus;

final class WidgetTaskStatusResponseDTO extends Data
{
    public function __construct(
        public readonly TaskStatus $status,
        /** @var array<int, ChatMessageDTO>|null */
        public readonly ?array $messages = null,
    ) {}

}
