<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case ToolExecution = 'tool_execution';
    case Retrying = 'retrying';
    case Completed = 'completed';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Processing => 'Procesando',
            self::ToolExecution => 'Ejecutando herramientas',
            self::Retrying => 'Reintentando',
            self::Completed => 'Completado',
            self::Failed => 'Error',
        };
    }
}
