<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Spoke\AgentSummaryData;
/**
 * Envelope de respuesta para el listado de agentes de un tenant.
 */
final class AgentListResponseDTO extends Data
{
    public function __construct(
        /** @var array<int, AgentSummaryData>|null */
        public readonly ?array $agents = null,
    ) {}
}
