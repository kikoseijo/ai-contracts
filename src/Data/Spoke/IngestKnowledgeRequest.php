<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

/**
 * Encola un VaultDocument ya creado para procesamiento RAG.
 * Devuelve task_id garantizado — usar para hacer polling de estado.
 *
 * Flujo: POST /vaults/{id}/documents → document_id → POST /knowledge/ingest → task_id
 */
final class IngestKnowledgeRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Ulid]
        public readonly string $vault_document_id,
    ) {}
}
