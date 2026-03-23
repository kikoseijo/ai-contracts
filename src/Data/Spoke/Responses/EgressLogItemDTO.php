<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Representa una entrada de log de egress reciente de un agente.
 */
final class EgressLogItemDTO extends Data
{
    public function __construct(
        public readonly string $task_id,
        public readonly string $endpoint_url,
        public readonly ?int $http_status,
        public readonly ?string $response_body,
        public readonly ?string $created_at,
    ) {}

}
