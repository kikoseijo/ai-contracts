<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

/**
 * Tipo de contenido de un documento en una bóveda de conocimiento.
 */
enum VaultDocumentType: string
{
    case Document = 'document';
    case Audio = 'audio';
    case Image = 'image';
    case Text = 'text';

    public function label(): string
    {
        return trans("ai-contracts::enums.vault_document_types.{$this->value}");
    }

    public function icon(): string
    {
        return match ($this) {
            self::Document => 'heroicon-o-document-text',
            self::Audio => 'heroicon-o-musical-note',
            self::Image => 'heroicon-o-photo',
            self::Text => 'heroicon-o-bars-3-bottom-left',
            default => 'heroicon-o-document',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Document => 'blue',
            self::Audio => 'purple',
            self::Image => 'amber',
            self::Text => 'slate',
            default => 'gray',
        };
    }
}
