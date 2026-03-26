<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Spoke\AgentSummaryData;
use Spatie\LaravelData\DataCollection;
/**
 * Envelope de respuesta para el listado de agentes de un tenant.
 */
final class AgentListResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(AgentSummaryData::class)]
        public readonly DataCollection $agents,
    ) {}
}
