<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Sunnyface\Contracts\Data\Spoke\Payloads\ConversationalPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\DocumentClassifierPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\VisionExtractorPayloadDTO;
use Sunnyface\Contracts\Enums\HandlerSlug;

class CognitivePayloadCast implements Cast
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
            HandlerSlug::Talker, HandlerSlug::FinancialAdvisor, HandlerSlug::CustomsAdvisor, HandlerSlug::MetaAgent => ConversationalPayloadDTO::from($value),
            HandlerSlug::DocumentClassifier => DocumentClassifierPayloadDTO::from($value),
            HandlerSlug::VisionExtractor, HandlerSlug::FinancialExtractor => VisionExtractorPayloadDTO::from($value),
            default => $value,
        };
    }
}
