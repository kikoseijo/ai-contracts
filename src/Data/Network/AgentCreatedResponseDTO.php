<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\HandlerSlug;

/**
 * Respuesta canónica del Hub tras crear un agente.
 * Normaliza la estructura independientemente de si el Hub devuelve
 * { id, ... } o { agent: { id, ... } }.
 */
final class AgentCreatedResponseDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly HandlerSlug $handler_slug,
        public readonly bool $is_active,
        /** @var array<string, mixed>|null */
        public readonly ?array $configuration = null,
    ) {}
}
