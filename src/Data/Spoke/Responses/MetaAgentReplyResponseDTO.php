<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica del Meta-Agente tras procesar un mensaje.
 */
final class MetaAgentReplyResponseDTO extends Data
{
    public function __construct(
        public readonly string $reply,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
