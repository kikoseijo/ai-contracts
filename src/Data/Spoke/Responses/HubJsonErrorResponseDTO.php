<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

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

    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return $this->httpStatus; // HTTP Status Code
    }
}
