<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

final class SpokeToolExecutionResponseDTO extends Data
{
    public function __construct(
        public readonly bool $success,
        /** @var array<string, mixed> */
        public readonly array $data,
        public readonly ?string $error_message = null,
    ) {}
}
