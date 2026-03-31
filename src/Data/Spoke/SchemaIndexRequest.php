<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

/**
 * Solicita el índice de esquemas de tareas disponibles para un handler concreto del tenant.
 * El Hub devuelve los schemas JSON registrados para ese handler_slug.
 *
 * Flujo: Spoke GET /schemas → Hub consulta TaskSchemas por tenant + handler_slug → Spoke cachea schemas
 */
final class SchemaIndexRequest extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Max(100)]
        public readonly string $handler_slug,
    ) {}
}
