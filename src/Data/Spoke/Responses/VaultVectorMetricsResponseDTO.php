<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Network\VaultDocumentMetricDTO;

/**
 * Respuesta de volumetría vectorial de una bóveda.
 * Usada en la API Hub → Spoke para el mapa de calor.
 */
final class VaultVectorMetricsResponseDTO extends Data
{
    public function __construct(
        public readonly int $total_chunks,
        /** @var array<int, VaultDocumentMetricDTO>|null */
        public readonly ?array $documents = null,
    ) {}

}
