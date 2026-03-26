<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Sunnyface\Contracts\Data\Network\VaultSummaryDTO;

/**
 * Respuesta del Hub al listar las bóvedas de un tenant.
 */
final class VaultListResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(VaultSummaryDTO::class)]
        public readonly ?DataCollection $vaults = null,
    ) {}

}
