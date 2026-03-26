<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Llm;

use Spatie\LaravelData\Data;

/**
 * Respuesta estructurada del agente conversacional hacia el Spoke.
 *
 * Encapsula la respuesta textual del LLM junto con las citas de las fuentes
 * de la Bóveda de Conocimiento utilizadas para generarla.
 */
final class AiMessageData extends Data
{
    public function __construct(
        public readonly string $response,
        /** @var array<int, CitationDTO>|null */
        public readonly ?array $citations = null,
    ) {}
}
