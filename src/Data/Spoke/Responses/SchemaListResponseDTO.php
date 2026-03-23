<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica al listar los TaskSchemas disponibles para un handler.
 */
final class SchemaListResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(TaskSchemaItemDTO::class)]
        public readonly array $schemas,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
