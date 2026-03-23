<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Attributes\Hidden;
use Spatie\LaravelData\Data;

/**
 * Error JSON multi-campo para middleware Hub (tenant / widget / cuota).
 */
final class HubJsonErrorResponseDTO extends Data
{
    public function __construct(
        public readonly string $error,
        public readonly string $message,
        #[Hidden]
        public readonly int $httpStatus,
        #[Hidden]
        public readonly ?int $retry_after_seconds = null,
    ) {}

    public function toResponse($request): JsonResponse
    {
        $body = $this->toArray();

        if ($this->retry_after_seconds !== null) {
            $body['retry_after_seconds'] = $this->retry_after_seconds;
        }

        return response()->json($body, $this->httpStatus);
    }
}
