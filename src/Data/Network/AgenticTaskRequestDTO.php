<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Spoke\Payloads\ConversationalPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\DocumentClassifierPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\VisionExtractorPayloadDTO;

/**
 * Envelope canónico que cruza la frontera Spoke→Hub para iniciar una tarea.
 *
 * Toda petición de ejecución de agente DEBE viajar en este DTO.
 * El hub_task_id no existe: el identificador unificado es task_id y lo asigna el Hub.
 */
final class AgenticTaskRequestDTO extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Ulid]
        public readonly string $agent_id,
        #[Required]
        public readonly ConversationalPayloadDTO|DocumentClassifierPayloadDTO|VisionExtractorPayloadDTO|array $input_payload,
    ) {}
}
