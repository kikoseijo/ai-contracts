<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\TaskStatus;

final class TaskStatusItemDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
        public readonly TaskStatus $status,
        public readonly ?array $output_payload = null,
        public readonly ?array $error_details = null,
    ) {}
}
