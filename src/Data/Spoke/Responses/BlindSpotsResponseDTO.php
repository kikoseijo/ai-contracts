<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Respuesta canónica del endpoint BlindSpots: últimas tareas fallidas de un tenant.
 */
final class BlindSpotsResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(BlindSpotItemDTO::class)]
        public readonly ?DataCollection $blind_spots = null,
    ) {}

}
