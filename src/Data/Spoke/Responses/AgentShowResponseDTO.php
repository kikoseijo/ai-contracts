<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Spoke\AgentSummaryData;

/**
 * Envelope de respuesta para el detalle de un único agente.
 */
final class AgentShowResponseDTO extends Data
{
    public function __construct(
        public readonly AgentSummaryData $agent,
    ) {}

}
