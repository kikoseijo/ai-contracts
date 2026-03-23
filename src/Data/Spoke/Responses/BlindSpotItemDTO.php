<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Representa una tarea fallida (punto ciego) en el reporte de BlindSpots.
 */
final class BlindSpotItemDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
        public readonly string $agent_name,
        public readonly mixed $question,
        public readonly mixed $error,
        public readonly string $date,
    ) {}
}
