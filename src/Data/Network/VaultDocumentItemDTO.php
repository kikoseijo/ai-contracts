<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentStatus;
use Sunnyface\Contracts\Enums\VaultDocumentType;

/**
 * Documento de bóveda con sus extracciones.
 */
final class VaultDocumentItemDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly VaultDocumentType $type,
        public readonly DocumentStatus $status,
        public readonly int $byte_size,
        /** @var array<string, mixed>|null */
        public readonly ?array $metadata,
        public readonly int $retries_count,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly int $file_size_bytes,
        public readonly ?int $page_count,
        #[DataCollectionOf(VaultDocumentExtractionDTO::class)]
        public readonly DataCollection $extractions,
    ) {}
}
