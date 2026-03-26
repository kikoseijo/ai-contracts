<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Payloads;

use Spatie\LaravelData\Data;

abstract class BasePayloadData extends Data
{
    // Esta clase sirve como contrato polimórfico.
    // Todos los DTOs de payloads de Tasks deben extender de aquí.
}
