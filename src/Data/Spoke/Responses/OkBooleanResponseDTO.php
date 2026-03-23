<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

/** Respuesta mínima `{ "ok": true }` para health checks y rutas de prueba. */
final class OkBooleanResponseDTO extends Data
{
    public function __construct(
        public readonly bool $ok = true,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this);
    }
}
