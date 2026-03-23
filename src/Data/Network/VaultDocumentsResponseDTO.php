<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/**
 * Respuesta del Hub al solicitar los documentos de una bóveda.
 */
final class VaultDocumentsResponseDTO extends Data
{
    public function __construct(
        public readonly VaultItemDTO $vault,
        #[DataCollectionOf(VaultDocumentItemDTO::class)]
        public readonly array $documents,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
