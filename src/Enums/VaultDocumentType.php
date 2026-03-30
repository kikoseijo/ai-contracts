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
    case Video = 'video';

    public function label(): string
    {
        return trans("ai-contracts::enums.vault_document_types.{$this->value}");
    }

    public function icon(): string
    {
        return match ($this) {
            self::Document => 'lucide-file-text',
            self::Audio => 'lucide-music',
            self::Image => 'lucide-image',
            self::Text => 'lucide-list',
            self::Video => 'lucide-video',
            default => 'lucide-file',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Document => 'blue',
            self::Audio => 'purple',
            self::Image => 'amber',
            self::Text => 'slate',
            self::Video => 'cyan',
            default => 'gray',
        };
    }
}
