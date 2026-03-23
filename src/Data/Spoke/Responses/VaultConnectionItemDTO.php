<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Representa una bóveda de conocimiento en el payload de Connections.
 */
final class VaultConnectionItemDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $magic_email,
    ) {}

}
