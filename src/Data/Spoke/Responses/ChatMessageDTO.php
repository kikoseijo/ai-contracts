<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\MessageRole;

/**
 * Representa un mensaje individual en el historial de chat de un agente Talker.
 */
final class ChatMessageDTO extends Data
{
    public function __construct(
        public readonly MessageRole $role,
        public readonly ?string $content,
        public readonly ?string $parsed_content,
    ) {}
}
