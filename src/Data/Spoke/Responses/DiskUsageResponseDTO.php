<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Respuesta canónica de uso de disco para un tenant.
 */
final class DiskUsageResponseDTO extends Data
{
    public function __construct(
        public readonly int $used_bytes,
        public readonly int $total_bytes,
        public readonly float $percentage,
    ) {}

}
