<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

final class WidgetRateLimitedResponseDTO extends Data
{
    public function __construct(
        public readonly string $error,
        public readonly string $message,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 429);
    }
}
