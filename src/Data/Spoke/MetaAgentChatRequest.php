<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

/**
 * Envía un mensaje al MetaAgent del tenant para conversación asistida de configuración.
 * El Hub responde con sugerencias de configuración de agentes en lenguaje natural.
 *
 * Flujo: Spoke POST /meta-agent/chat → Hub responde con LLM conversacional → Spoke muestra respuesta
 */
final class MetaAgentChatRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Max(2000)]
        public readonly string $message,
    ) {}
}
