<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

use Sunnyface\Contracts\Data\Spoke\UiManifestData;

enum HandlerSlug: string
{
    case Talker = 'talker';
    case TextTranslator = 'text-translator';
    case VisionExtractor = 'vision-extractor';
    case DocumentClassifier = 'document-classifier';
    case MetaAgent = 'meta-agent';
    case VaultIngest = 'vault.ingest';

    public function label(): string
    {
        return match ($this) {
            self::Talker => 'Conversacional (Talker)',
            self::TextTranslator => 'Traductor de Texto',
            self::VisionExtractor => 'Extractor Visual',
            self::DocumentClassifier => 'Clasificador de Documentos',
            self::MetaAgent => 'Meta-Agente del Sistema',
            self::VaultIngest => 'Ingesta de Bóveda',
        };
    }

    public function isWorker(): bool
    {
        return ! in_array($this, [self::Talker, self::MetaAgent], true);
    }

    public function uiManifest(): UiManifestData
    {
        return match ($this) {
            self::Talker, self::MetaAgent, self::TextTranslator => new UiManifestData(
                components: [AgentComponent::Chat, AgentComponent::BitacoraWidget],
            ),
            self::VisionExtractor, self::DocumentClassifier => new UiManifestData(
                components: [AgentComponent::ExtractorForm, AgentComponent::BitacoraWidget, AgentComponent::StatusBadge],
            ),
            self::VaultIngest => new UiManifestData(
                components: [AgentComponent::VaultIngestForm],
            ),
        };
    }
}
