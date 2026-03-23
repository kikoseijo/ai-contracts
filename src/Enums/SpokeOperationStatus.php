<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum SpokeOperationStatus: string
{
    case Created = 'created';
    case Updated = 'updated';
    case Toggled = 'toggled';
    case Provisioned = 'provisioned';
    case ToppedUp = 'topped_up';
    case Accepted = 'accepted';
    case Processing = 'processing';
}
