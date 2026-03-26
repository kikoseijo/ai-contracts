<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Respuesta canónica del endpoint BlindSpots: últimas tareas fallidas de un tenant.
 */
final class BlindSpotsResponseDTO extends Data
{
    public function __construct(
        /** @var array<int, BlindSpotItemDTO>|null */
        public readonly ?array $blind_spots = null,
    ) {}

}
