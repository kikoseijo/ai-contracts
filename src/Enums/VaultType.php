<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum VaultType: string
{
    case Raw = 'raw';
    case Rag = 'rag';
    case Extraction = 'extraction';
    case Classification = 'classification';

    public function label(): string
    {
        $key = $this->value;
        return trans("ai-contracts::enums.vault_types.{$key}.label");
    }

    public function description(): string
    {
        $key = $this->value;
        return trans("ai-contracts::enums.vault_types.{$key}.description");
    }

    public function icon(): string
    {
        return match ($this) {
            self::Raw => 'heroicon-o-document-text',
            self::Rag => 'heroicon-o-magnifying-glass-circle',
            self::Extraction => 'heroicon-o-table-cells',
            self::Classification => 'heroicon-o-tag',
            default => 'heroicon-o-cube',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Raw => 'slate',
            self::Rag => 'emerald',
            self::Extraction => 'blue',
            self::Classification => 'amber',
            default => 'gray',
        };
    }
}
