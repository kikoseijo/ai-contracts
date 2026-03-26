<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Respuesta canónica de conexiones (bóvedas y agentes) de un tenant.
 */
final class ConnectionsResponseDTO extends Data
{
    public function __construct(
        /** @var array<int, VaultConnectionItemDTO>|null */
        public readonly ?array $vaults = null,
        /** @var array<int, AgentConnectionItemDTO>|null */
        public readonly ?array $agents = null,
    ) {}

}
