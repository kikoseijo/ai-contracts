<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentStatus;

/**
 * Respuesta canónica 202 cuando el Hub acepta y encola una ingesta de documento desde el Spoke.
 */
final class KnowledgeIngestQueuedResponseDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
        public readonly string $message = 'Ingesta encolada en el Hub.',
        public readonly DocumentStatus $status = DocumentStatus::Queued,
    ) {}

    


    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return 202;
    }
}
