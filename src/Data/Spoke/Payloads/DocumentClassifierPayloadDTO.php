<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Payloads;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

use Sunnyface\Contracts\Data\Spoke\Payloads\BasePayloadData;

final class DocumentClassifierPayloadDTO extends BasePayloadData
{
    public function __construct(
        #[Required]
        public readonly string $content,
        public readonly ?string $file_url = null,
        public readonly ?string $base64 = null,
    ) {}
}
