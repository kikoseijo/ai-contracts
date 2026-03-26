<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Sunnyface\Contracts\Data\Spoke\Payloads\BaseOutputPayloadData;

/**
 * Representa la estructura del output_payload que devuelve el Hub.
 */
final class TaskOutputPayloadDTO extends BaseOutputPayloadData
{
    public function __construct(
        public readonly ?string $response = null,
        public readonly ?array $sources = null,
        public readonly ?array $citations = null,
        /** @var array<int, float>|null */
        public readonly ?array $interaction_embedding = null,
        public readonly ?array $pending_schema_creation = null,
    ) {}
}
