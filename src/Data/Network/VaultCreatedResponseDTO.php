<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta del Hub tras crear una bóveda.
 */
final class VaultCreatedResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly VaultItemDTO $vault,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 201);
    }
}
