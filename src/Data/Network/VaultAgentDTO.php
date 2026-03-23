<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Resumen de agente asociado a una bóveda.
 */
final class VaultAgentDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {}
}
