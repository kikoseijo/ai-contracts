<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\VaultType;

class CreateVaultRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Max(255)]
        public readonly string $name,
        public readonly VaultType $type = VaultType::Raw,
        #[Max(1000)]
        public readonly ?string $description = null,
    ) {}

    /**
     * Punto explícito de frontera Hub: el controlador pasa el contrato validado a la acción.
     */
    public function toDTO(): self
    {
        return $this;
    }
}
