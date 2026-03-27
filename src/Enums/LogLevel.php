<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum LogLevel: string
{
    case Info = 'info';
    case Warning = 'warning';
    case Error = 'error';
    case Critical = 'critical';

    public function label(): string
    {
        return trans("ai-contracts::enums.log_levels.{$this->value}");
    }

    public function icon(): string
    {
        return match ($this) {
            self::Info => 'lucide-info',
            self::Warning => 'lucide-triangle-alert',
            self::Error => 'lucide-circle-x',
            self::Critical => 'lucide-flame',
            default => 'lucide-message-square-text',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Info => 'blue',
            self::Warning => 'amber',
            self::Error => 'red',
            self::Critical => 'rose',
            default => 'gray',
        };
    }
}
