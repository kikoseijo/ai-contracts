<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\HandlerSlug;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta canónica tras actualizar un agente (nombre, handler_slug, etc.).
 */
final class AgentUpdatedResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly string $agent_id,
        public readonly ?string $agent_name,
        public readonly HandlerSlug $agent_handler_slug,
    ) {}


    /**
     * @return array{status: string, agent: array{id: string, name: string|null, handler_slug: string}}
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status->value,
            'agent' => [
                'id' => $this->agent_id,
                'name' => $this->agent_name,
                'handler_slug' => $this->agent_handler_slug->value,
            ],
        ];
    }
}
