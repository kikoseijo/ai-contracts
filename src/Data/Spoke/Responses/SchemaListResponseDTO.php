<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Respuesta canónica al listar los TaskSchemas disponibles para un handler.
 */
final class SchemaListResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(TaskSchemaItemDTO::class)]
        public readonly ?DataCollection $schemas = null,
    ) {}

}
