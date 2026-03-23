<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta canónica tras encolar una tarea desde el Spoke.
 */
final class TaskCreatedResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly string $task_id,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 201);
    }
}
