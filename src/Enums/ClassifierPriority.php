<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum ClassifierPriority: string
{
    case Low = 'low';
    case Normal = 'normal';
    case High = 'high';
    case Urgent = 'urgent';
}
