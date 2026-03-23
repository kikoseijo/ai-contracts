<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta 202 tras aceptar una tarea vía API de agente (no Spoke satélite).
 */
final class DirectTaskAcceptedResponseDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
        public readonly SpokeOperationStatus $status,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 202);
    }
}
