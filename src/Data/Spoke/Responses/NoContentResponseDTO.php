<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\Hidden;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica HTTP 204 No Content para operaciones de eliminación exitosas.
 */
final class NoContentResponseDTO extends Data
{
    public function __construct(
        #[Hidden]
        public readonly bool $noop = true,
    ) {}

}
