<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

/**
 * Slugs canónicos de los componentes Livewire que el Spoke debe montar para un agente.
 * Utilizado en UiManifestData::$components para garantizar tipado estricto.
 */
enum AgentComponent: string
{
    case Chat = 'chat';
    case BitacoraWidget = 'bitacora-widget';
    case ExtractorForm = 'extractor-form';
    case StatusBadge = 'status-badge';
    case VaultIngestForm = 'vault-ingest-form';
}
