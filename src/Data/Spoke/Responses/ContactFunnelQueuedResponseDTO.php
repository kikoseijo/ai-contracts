<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

final class ContactFunnelQueuedResponseDTO extends Data
{
    public function __construct(
        public readonly string $message,
        public readonly string $task_id,
        public readonly SpokeOperationStatus $status,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 202);
    }
}
