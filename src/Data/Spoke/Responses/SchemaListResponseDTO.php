<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Respuesta canónica al listar los TaskSchemas disponibles para un handler.
 */
final class SchemaListResponseDTO extends Data
{
    public function __construct(
        /** @var array<int, TaskSchemaItemDTO>|null */
        public readonly ?array $schemas = null,
    ) {}

}
