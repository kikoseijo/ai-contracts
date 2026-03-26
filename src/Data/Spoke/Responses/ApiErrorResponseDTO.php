<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\Hidden;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica de error HTTP para todos los endpoints del Hub → Spoke.
 */
final class ApiErrorResponseDTO extends Data
{
    public function __construct(
        public readonly string $error,
        #[Hidden]
        public readonly int $httpStatus,
    ) {}

    public function toResponse($request)
    {
        return response()->json($this, $this->httpStatus);
    }

}
