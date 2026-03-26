<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Network\VaultSummaryDTO;

/**
 * Respuesta del Hub al listar las bóvedas de un tenant.
 */
final class VaultListResponseDTO extends Data
{
    public function __construct(
        /** @var array<int, VaultSummaryDTO>|null */
        public readonly ?array $vaults = null,
    ) {}

}
