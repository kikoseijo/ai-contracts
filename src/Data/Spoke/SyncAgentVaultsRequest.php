<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Data;

final class SyncAgentVaultsRequest extends Data
{
    /**
     * @param string[] $vault_ids
     */
    public function __construct(
        public readonly string $tenant_id,
        public readonly array $vault_ids,
    ) {}
}
