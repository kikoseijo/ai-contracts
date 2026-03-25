<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

final class SpokeToolExecutionRequestDTO extends Data
{
    public function __construct(
        public readonly string $tenant_id,
        public readonly string $tenant_agent_id,
        public readonly string $tool_name,
        /** @var array<string, mixed> */
        public readonly array $arguments = [],
    ) {}
}
