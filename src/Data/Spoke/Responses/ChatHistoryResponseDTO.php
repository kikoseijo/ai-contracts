<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica del endpoint de historial de chat de un agente Talker.
 * El JSON es un array raíz de mensajes (sin envelope), no el shape por defecto de Data.
 */
final class ChatHistoryResponseDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(ChatMessageDTO::class)]
        public readonly array $messages,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json(array_map(
            static fn (ChatMessageDTO $msg): array => $msg->toArray(),
            $this->messages,
        ), 200);
    }
}
