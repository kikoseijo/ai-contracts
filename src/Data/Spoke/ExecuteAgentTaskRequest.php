<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Spoke\Payloads\ConversationalPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\DocumentClassifierPayloadDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\VisionExtractorPayloadDTO;

class ExecuteAgentTaskRequest extends Data
{
    /**
     * @param  array<int, \Sunnyface\Contracts\Data\Spoke\Responses\ChatMessageDTO>|null  $prefetched_chat_messages
     */
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required]
        public readonly ConversationalPayloadDTO|DocumentClassifierPayloadDTO|VisionExtractorPayloadDTO $payload,
        public readonly ?array $prefetched_chat_messages = null,
    ) {}
}
