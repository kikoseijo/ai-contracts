<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentStatus;

/**
 * Respuesta canónica tras encolar un documento de bóveda desde el Spoke (upload o reindex).
 */
final class VaultDocumentQueuedResponseDTO extends Data
{
    public function __construct(
        public readonly DocumentStatus $status,
        public readonly string $document_id,
        public readonly ?string $task_id,
    ) {}

    


    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return 202;
    }
}
