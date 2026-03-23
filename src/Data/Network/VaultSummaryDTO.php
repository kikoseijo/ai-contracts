<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\VaultType;

/**
 * Resumen de una bóveda para el listado del Spoke.
 * Incluye contadores de documentos y agentes asociados.
 */
final class VaultSummaryDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly VaultType $type,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly int $documents_count,
        public readonly int $processed_count,
        #[DataCollectionOf(VaultAgentDTO::class)]
        public readonly array $tenant_agents,
        public readonly bool $is_system = false,
    ) {}
}
