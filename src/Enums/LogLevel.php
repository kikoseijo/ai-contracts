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
            self::Info => 'heroicon-o-information-circle',
            self::Warning => 'heroicon-o-exclamation-triangle',
            self::Error => 'heroicon-o-x-circle',
            self::Critical => 'heroicon-o-fire',
            default => 'heroicon-o-chat-bubble-bottom-center-text',
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
