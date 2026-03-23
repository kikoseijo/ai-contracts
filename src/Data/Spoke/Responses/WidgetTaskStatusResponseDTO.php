<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\TaskStatus;

final class WidgetTaskStatusResponseDTO extends Data
{
    public function __construct(
        public readonly TaskStatus $status,
        #[DataCollectionOf(ChatMessageDTO::class)]
        public readonly array $messages,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this);
    }
}
