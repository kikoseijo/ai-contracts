<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum InsightSeverity: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Critical = 'critical';
}
