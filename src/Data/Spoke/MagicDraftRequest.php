<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

/**
 * Genera un borrador de agente usando IA a partir de una descripción en lenguaje natural.
 * El Hub devuelve un `MagicDraftResponseDTO` con el nombre, prompt y herramientas sugeridas.
 *
 * Flujo: Spoke POST /magic-draft → Hub genera borrador con LLM → Spoke aplica al TenantAgent
 */
final class MagicDraftRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Ulid]
        public readonly string $tenant_agent_id,
        #[Required, Min(20), Max(2000)]
        public readonly string $description,
    ) {}
}
