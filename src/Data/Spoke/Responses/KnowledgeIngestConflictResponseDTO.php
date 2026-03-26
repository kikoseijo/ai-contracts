<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentStatus;

/**
 * Respuesta canónica 409 cuando el Hub rechaza la ingesta porque el documento ya fue procesado o está en proceso.
 */
final class KnowledgeIngestConflictResponseDTO extends Data
{
    public function __construct(
        public readonly string $message,
        public readonly DocumentStatus $status,
    ) {}


    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return 409; // Conflict
    }
}
