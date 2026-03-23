<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

/**
 * Envelope canónico que cruza la frontera Spoke→Hub para iniciar una tarea.
 *
 * Toda petición de ejecución de agente DEBE viajar en este DTO.
 * El hub_task_id no existe: el identificador unificado es task_id y lo asigna el Hub.
 *
 * @param  array<string, mixed>  $input_payload  Parámetros de ejecución propios del handler.
 */
final class AgenticTaskRequestDTO extends Data
{
    /** @param array<string, mixed> $input_payload */
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Ulid]
        public readonly string $agent_id,
        #[Required]
        public readonly array $input_payload,
    ) {}
}
