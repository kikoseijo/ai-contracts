<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/**
 * Respuesta del Hub al listar las bóvedas de un tenant.
 */
final class VaultListResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(VaultSummaryDTO::class)]
        public readonly array $vaults,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
