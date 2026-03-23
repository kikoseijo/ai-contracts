<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta canónica tras recargar tokens de cuota de un tenant.
 */
final class QuotaTopUpResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly int $available_tokens,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this);
    }
}
