<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Llm;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
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
        #[DataCollectionOf(CitationDTO::class)]
        public readonly ?DataCollection $citations = null,
    ) {}
}
