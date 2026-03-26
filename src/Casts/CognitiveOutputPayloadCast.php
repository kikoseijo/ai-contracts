<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Sunnyface\Contracts\Data\Classifier\ClassifierOutputDTO;
use Sunnyface\Contracts\Data\Extractor\InvoiceOutputDTO;
use Sunnyface\Contracts\Data\Network\TaskOutputPayloadDTO;
use Sunnyface\Contracts\Data\Translator\TranslatorOutputDTO;
use Sunnyface\Contracts\Enums\HandlerSlug;

class CognitiveOutputPayloadCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
    {
        $slugValue = $properties['handlerSlug'] ?? $properties['handler_slug'] ?? null;

        if (! $slugValue || ! is_array($value)) {
            return $value;
        }

        $slug = $slugValue instanceof HandlerSlug ? $slugValue : HandlerSlug::tryFrom($slugValue);

        if (! $slug) {
            return $value;
        }

        return match ($slug) {
            HandlerSlug::Talker, HandlerSlug::FinancialAdvisor, HandlerSlug::CustomsAdvisor, HandlerSlug::MetaAgent => TaskOutputPayloadDTO::from($value),
            HandlerSlug::DocumentClassifier => ClassifierOutputDTO::from($value),
            HandlerSlug::VisionExtractor, HandlerSlug::FinancialExtractor => InvoiceOutputDTO::from($value),
            default => $value,
        };
    }
}
