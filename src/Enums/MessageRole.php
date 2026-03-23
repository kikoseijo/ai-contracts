<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum MessageRole: string
{
    case User = 'user';
    case Assistant = 'assistant';
    case System = 'system';
    case Tool = 'tool';
}
