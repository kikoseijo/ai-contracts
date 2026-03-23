<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta canónica tras activar/desactivar un agente.
 */
final class AgentToggledResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly string $id,
        public readonly bool $is_active,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this);
    }
}
