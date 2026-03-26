<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta canónica tras actualizar la configuración personalizada de un agente (talker config).
 */
final class AgentConfigUpdatedResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly string $agent_id,
    ) {}

}
