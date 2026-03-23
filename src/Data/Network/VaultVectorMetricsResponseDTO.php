<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/**
 * Respuesta de volumetría vectorial de una bóveda.
 * Usada en la API Hub → Spoke para el mapa de calor.
 */
final class VaultVectorMetricsResponseDTO extends Data
{
    public function __construct(
        public readonly int $total_chunks,
        #[DataCollectionOf(VaultDocumentMetricDTO::class)]
        public readonly array $documents,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
