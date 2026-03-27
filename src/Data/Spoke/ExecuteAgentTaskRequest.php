<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Spoke\Casts\PayloadPolymorphicCast;
use Sunnyface\Contracts\Data\Spoke\Payloads\BasePayloadData;

final class ExecuteAgentTaskRequest extends Data
{
    /**
     * @param  array<int, \Sunnyface\Contracts\Data\Spoke\Responses\ChatMessageDTO>|null  $prefetched_chat_messages
     */
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,

        #[Required]
        public readonly string $task_type,

        #[Required]
        #[WithCast(PayloadPolymorphicCast::class)]
        public readonly BasePayloadData $payload,

        #[Ulid]
        public readonly ?string $tenant_agent_id = null,

        public readonly ?array $prefetched_chat_messages = null,
    ) {}
}
