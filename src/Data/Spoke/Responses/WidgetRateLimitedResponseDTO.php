<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

final class WidgetRateLimitedResponseDTO extends Data
{
    public function __construct(
        public readonly string $error,
        public readonly string $message,
    ) {}


    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return 429; // Rate Limited
    }
}
