<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\SunnyGestorWebhookStatus;
use Sunnyface\Contracts\Enums\SunnyGestorIntentType;

final class SunnyGestorWebhookDTO extends Data
{
    /**
     * @param string $tenant_id
     * @param string $intent_id
     * @param SunnyGestorWebhookStatus $status
     * @param SunnyGestorIntentType $detected_type
     * @param string $hub_message
     * @param SunnyGestorExtractedDataDTO|null $extracted_data
     */
    public function __construct(
        public readonly string $tenant_id,
        public readonly string $intent_id,
        public readonly SunnyGestorWebhookStatus $status,
        public readonly SunnyGestorIntentType $detected_type,
        public readonly string $hub_message,
        public readonly ?SunnyGestorExtractedDataDTO $extracted_data = null,
    ) {}
}
