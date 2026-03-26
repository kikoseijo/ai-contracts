<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica de conexiones (bóvedas y agentes) de un tenant.
 */
final class ConnectionsResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(VaultConnectionItemDTO::class)]
        public readonly DataCollection $vaults,
        #[DataCollectionOf(AgentConnectionItemDTO::class)]
        public readonly DataCollection $agents,
    ) {}

}
