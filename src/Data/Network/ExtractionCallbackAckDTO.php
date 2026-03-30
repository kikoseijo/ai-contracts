<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

final class ExtractionCallbackAckDTO extends Data
{
    public function __construct(
        public readonly bool $received = true,
    ) {}
}
