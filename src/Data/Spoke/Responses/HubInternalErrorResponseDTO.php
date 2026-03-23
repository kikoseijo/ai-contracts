<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

final class HubInternalErrorResponseDTO extends Data
{
    public function __construct(
        public readonly bool $debug,
        public readonly ?string $debugMessage = null,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 500);
    }

    /**
     * @return array{status: string, message: string, debug: string|null}
     */
    public function toArray(): array
    {
        return [
            'status' => 'error',
            'message' => 'Internal Hub Error. Logged for review.',
            'debug' => $this->debug ? $this->debugMessage : null,
        ];
    }
}
