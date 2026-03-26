<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\TaskStatus;

/**
 * Respuesta del Hub tras encolar una tarea (worker o chat).
 * Normaliza task_id como campo canónico, absorbiendo cualquier
 * alias que el Hub pueda usar internamente (hub_task_id, id, etc.).
 */
final class TaskCreatedResponseDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
        public readonly TaskStatus $status,
    ) {}

    public function toResponse($request)
    {
        return response()->json($this, 202);
    }

}
