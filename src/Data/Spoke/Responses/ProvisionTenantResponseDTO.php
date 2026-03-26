<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

/**
 * Respuesta canónica tras aprovisionar un tenant desde el Spoke.
 */
final class ProvisionTenantResponseDTO extends Data
{
    public function __construct(
        public readonly SpokeOperationStatus $status,
        public readonly string $tenant_id,
        public readonly ?string $default_agent_id = null,
        public readonly ?string $default_vault_id = null,
    ) {}

    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return 201;
    }

}
