<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\VaultType;

/**
 * Representación canónica de una bóveda de conocimiento.
 * Unifica VaultItemDTO (creación) y VaultInfoDTO (cabecera de documentos).
 */
final class VaultItemDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly VaultType $type,
        public readonly ?string $created_at = null,
        #[DataCollectionOf(VaultAgentDTO::class)]
        public readonly array $agents = [],
    ) {}
}
