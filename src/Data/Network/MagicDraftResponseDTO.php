<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;

/**
 * Respuesta del Hub tras generar la configuración de agente con IA.
 * Normaliza los nombres de campo canónicos que el componente Livewire espera.
 */
final class MagicDraftResponseDTO extends Data
{
    public function __construct(
        public readonly string $suggested_name,
        public readonly string $suggested_greeting,
        public readonly string $custom_instructions,
    ) {}
}
