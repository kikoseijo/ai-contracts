<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extractor;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\DocumentStatus;

class ExtractionCompletedWebhookDTO extends Data
{
    public DocumentStatus $status {
        get => $this->extracted_data !== null
            ? DocumentStatus::Success
            : DocumentStatus::Classified;
    }

    public function __construct(
        public readonly string $tenant_id,
        public readonly string $document_id,
        public readonly ?DocumentClassificationDTO $classification,
        public readonly mixed $extracted_data,
    ) {}
}
