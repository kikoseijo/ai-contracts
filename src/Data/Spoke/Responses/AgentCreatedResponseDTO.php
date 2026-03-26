<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\HandlerSlug;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta canónica tras crear un agente desde el Spoke.
 */
final class AgentCreatedResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly string $id,
        public readonly string $name,
        public readonly HandlerSlug $handler_slug,
        public readonly bool $is_active,
    ) {}

}
