<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

/**
 * Respuesta del Hub tras encolar un documento de bóveda para procesamiento.
 */
final class VaultDocumentEnqueuedResponseDTO extends Data
{
    public function __construct(
        public readonly string $document_id,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 202);
    }
}
