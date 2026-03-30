<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum SpokeDocumentStatus: string
{
    case Draft = 'draft';
    case AwaitingUser = 'awaiting_user';
    case FlaggedByAntivirus = 'flagged_by_antivirus';
    case Verified = 'verified';
    case PendingPayment = 'pending_payment';
    case Paid = 'paid';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Borrador',
            self::AwaitingUser => 'Pendiente de revision',
            self::FlaggedByAntivirus => 'Bloqueado por Antivirus',
            self::Verified => 'Verificado',
            self::PendingPayment => 'Pendiente de pago',
            self::Paid => 'Pagado',
            self::Cancelled => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'zinc',
            self::AwaitingUser => 'amber',
            self::FlaggedByAntivirus => 'red',
            self::Verified => 'green',
            self::PendingPayment => 'sky',
            self::Paid => 'emerald',
            self::Cancelled => 'zinc',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Draft => 'pencil-square',
            self::AwaitingUser => 'clock',
            self::FlaggedByAntivirus => 'shield-exclamation',
            self::Verified => 'check-badge',
            self::PendingPayment => 'banknotes',
            self::Paid => 'check-circle',
            self::Cancelled => 'x-circle',
        };
    }
}
