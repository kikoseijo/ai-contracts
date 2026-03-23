<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Payload que el Spoke envía al Hub para solicitar una configuración
 * de agente generada por IA (Varita Mágica).
 */
final class MagicDraftRequestDTO extends Data
{
    public function __construct(
        public readonly string $tenant_id,
        public readonly string $tenant_agent_id,
        public readonly string $description,
    ) {}
}
