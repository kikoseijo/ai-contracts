<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Payloads;

use Spatie\LaravelData\Data;

final class VisionExtractorPayloadDTO extends Data
{
    public function __construct(
        public readonly ?string $file_url = null,
        public readonly ?string $base64 = null,
        public readonly ?string $mime_type = null,
        public readonly ?string $force_schema = null,
    ) {}
}
