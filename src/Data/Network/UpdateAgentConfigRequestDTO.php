<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Payload que el Spoke envía al Hub para sincronizar la configuración de negocio
 * de un agente tipo Talker (nombre, saludo, instrucciones, bóvedas RAG).
 *
 * @param  array<int, string>  $vault_ids  IDs de bóvedas de conocimiento asignadas.
 */
final class UpdateAgentConfigRequestDTO extends Data
{
    /** @param array<int, string> $vault_ids */
    public function __construct(
        public readonly string $tenant_id,
        public readonly string $name,
        public readonly string $greeting,
        public readonly string $custom_instructions,
        /** @var array<int, string> */
        public readonly array $vault_ids,
    ) {}
}
