<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

final class WidgetChatEnqueuedResponseDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this);
    }
}
