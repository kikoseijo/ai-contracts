<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta canónica tras actualizar la configuración de extracción de un agente.
 */
final class AgentExtractorConfigResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly string $agent_id,
        public readonly ExtractorConfigDTO $extractor,
        public readonly ?string $knowledge_vault_id,
        public readonly ?string $webhook_url,
    ) {}

}
