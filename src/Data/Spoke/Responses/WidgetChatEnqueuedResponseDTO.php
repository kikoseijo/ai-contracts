<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

final class WidgetChatEnqueuedResponseDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
    ) {}

    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return 202; // Task Enqueued
    }

}
