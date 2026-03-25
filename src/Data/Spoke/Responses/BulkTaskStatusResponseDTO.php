<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

final class BulkTaskStatusResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(TaskStatusItemDTO::class)]
        public readonly array $tasks,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this);
    }
}
