<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Llm;

use Spatie\LaravelData\Data;

/**
 * Metadatos de una fuente de conocimiento citada en la respuesta del agente.
 */
final class CitationDTO extends Data
{
    public function __construct(
        public readonly string $doc_id,
        public readonly string $title,
        public readonly ?string $url,
    ) {}
}
