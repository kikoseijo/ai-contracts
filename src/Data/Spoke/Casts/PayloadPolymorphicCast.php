<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Sunnyface\Contracts\Data\Spoke\Payloads\ConversationalPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\DocumentClassifierPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\VisionExtractorPayloadDTO;

class PayloadPolymorphicCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        if (isset($value['message'])) {
            return ConversationalPayloadDTO::from($value);
        }

        if (isset($value['file_url']) || isset($value['base64'])) {
            return VisionExtractorPayloadDTO::from($value);
        }

        if (isset($value['content'])) {
            return DocumentClassifierPayloadDTO::from($value);
        }

        // Fallback por defecto
        return ConversationalPayloadDTO::from($value);
    }
}
