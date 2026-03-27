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
            self::Raw => 'lucide-file-text',
            self::Rag => 'lucide-scan-search',
            self::Extraction => 'lucide-table',
            self::Classification => 'lucide-tag',
            default => 'lucide-box',
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
