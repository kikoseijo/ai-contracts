<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica del insight diario de un tenant.
 */
final class InsightResponseDTO extends Data
{
    public function __construct(
        public readonly ?string $insight,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
