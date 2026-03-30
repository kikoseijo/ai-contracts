<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Sunnyface\Contracts\Data\Spoke\Payloads\BaseOutputPayloadData;
use Sunnyface\Contracts\Enums\VisionExtractorSchemaSlug;

/**
 * Representa la estructura del output_payload que devuelve el Hub.
 */
final class TaskOutputPayloadDTO extends BaseOutputPayloadData
{
    public function __construct(
        /**
         * MIME del documento procesado (p. ej. application/pdf, image/jpeg), alineado con
         * {@see \Sunnyface\Contracts\Data\Spoke\Payloads\VisionExtractorPayloadDTO::mime_type}
         * y el campo interno file_mime del pipeline de extracción.
         */
        public readonly ?string $file_type = null,
        /**
         * Slug del esquema aplicado en extracción visión (canónicos: {@see VisionExtractorSchemaSlug}).
         * El Hub lo replica en `metadata.schema_slug` del webhook de estado de tarea.
         */
        public readonly ?string $schema_slug = null,
        public readonly ?string $response = null,
        public readonly ?array $sources = null,
        public readonly ?array $citations = null,
        /** @var array<int, float>|null */
        public readonly ?array $interaction_embedding = null,
        public readonly ?array $pending_schema_creation = null,
    ) {}
}
