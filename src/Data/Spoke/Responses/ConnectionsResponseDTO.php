<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica de conexiones (bóvedas y agentes) de un tenant.
 */
final class ConnectionsResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(VaultConnectionItemDTO::class)]
        public readonly array $vaults,
        #[DataCollectionOf(AgentConnectionItemDTO::class)]
        public readonly array $agents,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
