<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Métrica vectorial de un documento dentro de una bóveda.
 */
final class VaultDocumentMetricDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $chunk_count,
    ) {}
}
