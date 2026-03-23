<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum UiComponent: string
{
    case Text = 'text';
    case Input = 'input';
    case Textarea = 'textarea';
    case Number = 'number';
    case Date = 'date';
    case File = 'file';
    case Toggle = 'toggle';
    case Select = 'select';
    case Tags = 'tags';
    case Badge = 'badge';
    case Table = 'table';
    case Repeater = 'repeater';
}
