<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

use Sunnyface\Contracts\Data\Spoke\UiManifestData;

enum HandlerSlug: string
{
    case Talker = 'talker';
    case FinancialAdvisor = 'financial-advisor';
    case CustomsAdvisor = 'customs-advisor';
    case TextTranslator = 'text-translator';
    case VisionExtractor = 'vision-extractor';
    case DocumentClassifier = 'document-classifier';
    case FinancialExtractor = 'financial-extractor';
    case MetaAgent = 'meta-agent';
    case VaultIngest = 'vault.ingest';

    public function label(): string
    {
        return match ($this) {
            self::Talker => 'Conversacional (Talker)',
            self::FinancialAdvisor => 'Asesor Financiero (Agentic)',
            self::CustomsAdvisor => 'Asesor de Aduanas (Agentic)',
            self::TextTranslator => 'Traductor de Texto',
            self::VisionExtractor => 'Extractor Visual',
            self::DocumentClassifier => 'Clasificador de Documentos',
            self::FinancialExtractor => 'Extractor Financiero',
            self::MetaAgent => 'Meta-Agente del Sistema',
            self::VaultIngest => 'Ingesta de Bóveda',
        };
    }

    public function isWorker(): bool
    {
        return ! in_array($this, [self::Talker, self::FinancialAdvisor, self::MetaAgent], true);
    }

    public function uiManifest(): UiManifestData
    {
        return match ($this) {
            self::Talker, self::CustomsAdvisor, self::FinancialAdvisor, self::MetaAgent, self::TextTranslator => new UiManifestData(
                components: [AgentComponent::Chat, AgentComponent::BitacoraWidget],
            ),
            self::VisionExtractor, self::DocumentClassifier, self::FinancialExtractor => new UiManifestData(
                components: [AgentComponent::ExtractorForm, AgentComponent::BitacoraWidget, AgentComponent::StatusBadge],
            ),
            self::VaultIngest => new UiManifestData(
                components: [AgentComponent::VaultIngestForm],
            ),
        };
    }
    
    public function color(): string
    {
        return match ($this) {
            self::Talker, self::FinancialAdvisor, self::CustomsAdvisor => 'primary',
            self::TextTranslator => 'info',
            self::VisionExtractor, self::FinancialExtractor => 'warning',
            self::DocumentClassifier => 'success',
            self::MetaAgent => 'danger',
            self::VaultIngest => 'gray',
        };
    }
}
