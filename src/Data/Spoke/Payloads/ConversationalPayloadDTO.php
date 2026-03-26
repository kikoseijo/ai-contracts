<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Payloads;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

use Sunnyface\Contracts\Data\Spoke\Payloads\BasePayloadData;

final class ConversationalPayloadDTO extends BasePayloadData
{
    public function __construct(
        #[Required]
        public readonly string $message,
        public readonly ?string $chat_session_id = null,
    ) {}
}
