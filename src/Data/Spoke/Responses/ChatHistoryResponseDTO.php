<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Respuesta canónica del endpoint de historial de chat de un agente Talker.
 * El JSON es un array raíz de mensajes (sin envelope), no el shape por defecto de Data.
 */
final class ChatHistoryResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(ChatMessageDTO::class)]
        public readonly ?DataCollection $messages = null,
    ) {}

}
