<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Representa un webhook de egress registrado para un agente.
 */
final class EgressWebhookItemDTO extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $url,
        public readonly bool $is_active,
    ) {}

}
