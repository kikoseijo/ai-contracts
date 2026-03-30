<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Support;

use Sunnyface\Contracts\Data\Spoke\Payloads\BasePayloadData;
use Sunnyface\Contracts\Data\Spoke\Payloads\ConversationalPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\DocumentClassifierPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\VisionExtractorPayloadDTO;
use Sunnyface\Contracts\Data\Network\TaskOutputPayloadDTO;
use Sunnyface\Contracts\Data\Classifier\ClassifierOutputDTO;
use Sunnyface\Contracts\Data\Translator\TranslatorOutputDTO;
use Sunnyface\Contracts\Enums\HandlerSlug;

/**
 * Factoría de hidratación polimórfica para payloads de tareas.
 *
 * Dado un HandlerSlug y un array crudo, devuelve el DTO fuertemente tipado
 * que corresponde al tipo de agente. Elimina la necesidad de union types
 * y match() manuales en los consumidores.
 */
final class PayloadHydrator
{
    /**
     * @param  array<string, mixed>  $payload
     */
    public static function hydrateOutput(HandlerSlug $handler, array $payload): object|array
    {
        return match ($handler) {
            HandlerSlug::Talker,
            HandlerSlug::FinancialAdvisor,
            HandlerSlug::CustomsAdvisor,
            HandlerSlug::MetaAgent,
            HandlerSlug::VisionExtractor,
            HandlerSlug::FinancialExtractor => TaskOutputPayloadDTO::from($payload),
            HandlerSlug::DocumentClassifier => ClassifierOutputDTO::from($payload),
            HandlerSlug::TextTranslator => TranslatorOutputDTO::from($payload),
            default => is_array($payload) ? (object) $payload : $payload,
        };
    }

    public static function hydrate(HandlerSlug $handler, array $payload): BasePayloadData
    {
        $dtoClass = self::resolve($handler);

        return $dtoClass::from($payload);
    }

    /**
     * @return class-string<BasePayloadData>
     */
    public static function resolve(HandlerSlug $handler): string
    {
        return match ($handler) {
            HandlerSlug::Talker,
            HandlerSlug::FinancialAdvisor,
            HandlerSlug::CustomsAdvisor,
            HandlerSlug::TextTranslator,
            HandlerSlug::MetaAgent => ConversationalPayloadDTO::class,

            HandlerSlug::VisionExtractor,
            HandlerSlug::FinancialExtractor => VisionExtractorPayloadDTO::class,

            HandlerSlug::DocumentClassifier => DocumentClassifierPayloadDTO::class,

            HandlerSlug::VaultIngest => ConversationalPayloadDTO::class,
        };
    }
}
