<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum PendingValidationStatus: string
{
    case Processing = 'processing';
    case ExtractionFailed = 'extraction_failed';
    case RequiresHumanConfirmation = 'requires_human_confirmation';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Resolved = 'resolved';

    public function label(): string
    {
        return match ($this) {
            self::Processing => 'Procesando',
            self::ExtractionFailed => 'Extraccion fallida',
            self::RequiresHumanConfirmation => 'Pendiente de revision',
            self::Approved => 'Aprobado',
            self::Rejected => 'Rechazado',
            self::Resolved => 'Resuelto',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Processing => 'amber',
            self::ExtractionFailed => 'red',
            self::RequiresHumanConfirmation => 'sky',
            self::Approved => 'green',
            self::Rejected => 'zinc',
            self::Resolved => 'emerald',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Processing => 'arrow-path',
            self::ExtractionFailed => 'exclamation-triangle',
            self::RequiresHumanConfirmation => 'eye',
            self::Approved => 'check-circle',
            self::Rejected => 'x-circle',
            self::Resolved => 'check-badge',
        };
    }

    public function isTerminal(): bool
    {
        return match ($this) {
            self::Approved, self::Rejected, self::Resolved => true,
            default => false,
        };
    }

    public function isActionable(): bool
    {
        return match ($this) {
            self::RequiresHumanConfirmation, self::ExtractionFailed => true,
            default => false,
        };
    }
}
