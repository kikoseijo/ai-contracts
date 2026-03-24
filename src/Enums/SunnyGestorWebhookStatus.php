<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum SunnyGestorWebhookStatus: string
{
    case Success = 'success';
    case Failed = 'failed';
    case RequiresMoreInfo = 'requires_more_info';
}
