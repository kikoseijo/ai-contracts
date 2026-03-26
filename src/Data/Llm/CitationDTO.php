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
        public private(set) string $doc_id,
        public private(set) string $title,
        public private(set) ?string $url,
    ) {}
}
