<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\MessageRole;

/**
 * Un turno de conversación con rol tipado para el historial del Meta-Agente.
 */
final class ConversationTurnDTO extends Data
{
    public function __construct(
        public readonly MessageRole $role,
        public readonly string $content,
    ) {}
}
