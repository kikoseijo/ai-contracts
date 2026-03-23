<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Data;

/**
 * Manifest de componentes UI que el Spoke debe renderizar para un agente.
 * Retornado por HandlerSlug::uiManifest().
 */
class UiManifestData extends Data
{
    public function __construct(
        public readonly array $components,
    ) {}
}
