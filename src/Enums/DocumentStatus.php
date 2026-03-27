<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum DocumentStatus: string
{
    case Pending = 'pending';
    case Queued = 'queued';
    case Processing = 'processing';
    case Reindexing = 'reindexing';
    case Extracted = 'extracted';
    case Transcribed = 'transcribed';
    case Chunked = 'chunked';
    case Processed = 'processed';
    case Classified = 'classified';
    case Completed = 'completed';
    case Success = 'success';
    case Failed = 'failed';
    case FailedSecurity = 'failed_security';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Queued => 'En cola',
            self::Processing => 'Procesando',
            self::Reindexing => 'Reindexando',
            self::Extracted => 'Extraído',
            self::Transcribed => 'Transcrito',
            self::Chunked => 'Fragmentado',
            self::Processed => 'Vectorizado',
            self::Classified => 'Clasificado',
            self::Completed => 'Completado',
            self::Success => 'Completado',
            self::Failed => 'Error',
            self::FailedSecurity => 'Error de Seguridad',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending, self::Queued => 'zinc',
            self::Processing, self::Reindexing, self::Extracted, self::Transcribed, self::Chunked => 'amber',
            self::Processed, self::Classified, self::Completed, self::Success => 'green',
            self::Failed, self::FailedSecurity => 'red',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Pending, self::Queued => 'lucide-clock',
            self::Processing, self::Reindexing, self::Extracted, self::Transcribed, self::Chunked => 'lucide-refresh-cw',
            self::Processed, self::Classified, self::Completed, self::Success => 'lucide-circle-check',
            self::Failed, self::FailedSecurity => 'lucide-triangle-alert',
        };
    }

    public function isTerminal(): bool
    {
        return match ($this) {
            self::Completed, self::Success, self::Failed, self::FailedSecurity => true,
            default => false,
        };
    }

    public function isTerminalSuccess(): bool
    {
        return match ($this) {
            self::Completed, self::Success => true,
            default => false,
        };
    }

    public function canReindex(): bool
    {
        return match ($this) {
            self::Failed, self::FailedSecurity => true,
            default => false,
        };
    }
}
