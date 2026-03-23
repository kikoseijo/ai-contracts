<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Envelope que el Spoke envía al Hub para un turno de conversación.
 * task_id es nulo en el primer mensaje; los siguientes lo incluyen para
 * mantener el hilo cognitivo en la misma sesión del Hub.
 */
final class ChatMessageRequestDTO extends Data
{
    public function __construct(
        public readonly string $message,
        public readonly ?string $task_id = null,
        public readonly ?string $file_path = null,
        public readonly ?string $file_mime = null,
    ) {}
}
