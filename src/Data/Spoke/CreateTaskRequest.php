<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;

class CreateTaskRequest extends Data
{
    /**
     * @param  array<string, mixed>  $input_payload
     * @param  array<int, array<string, mixed>>|null  $prefetched_chat_messages
     */
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, Ulid]
        public readonly string $tenant_agent_id,
        #[Required]
        public readonly array $input_payload,
        public readonly ?array $prefetched_chat_messages = null,
    ) {}
}
