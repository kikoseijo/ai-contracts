<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum LogCategory: string
{
    case Provisioning = 'provisioning';
    case Webhook = 'webhook';
    case Billing = 'billing';
    case Sync = 'sync';
    case Vault = 'vault';
    case Agent = 'agent';
    case Upload = 'upload';
    case Auth = 'auth';
}
