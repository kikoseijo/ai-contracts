<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica del endpoint BlindSpots: últimas tareas fallidas de un tenant.
 */
final class BlindSpotsResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(BlindSpotItemDTO::class)]
        public readonly array $blind_spots,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
