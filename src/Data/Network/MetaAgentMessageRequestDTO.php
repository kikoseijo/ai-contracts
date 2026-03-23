<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/**
 * Payload que el Spoke envía al Hub para un turno de conversación
 * con el Meta-Agente del sistema (orquestador central).
 */
final class MetaAgentMessageRequestDTO extends Data
{
    public function __construct(
        public readonly string $tenant_id,
        public readonly string $message,
        #[DataCollectionOf(ConversationTurnDTO::class)]
        public readonly array $history,
    ) {}
}
