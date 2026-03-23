<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Resultado de una extracción estructurada sobre un documento.
 */
final class VaultDocumentExtractionDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $schema_name,
        /** @var array<string, mixed> */
        public readonly array $extracted_data,
        public readonly string $created_at,
    ) {}
}
