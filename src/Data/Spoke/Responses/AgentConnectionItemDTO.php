<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Sunnyface\Contracts\Enums\HandlerSlug;

/**
 * Representa un agente con sus conexiones (vault, webhooks, logs) en el payload de Connections.
 */
final class AgentConnectionItemDTO extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly HandlerSlug $handler_slug,
        public readonly bool $is_active,
        public readonly ?string $knowledge_vault_id,
        public readonly ?string $magic_email,
        public readonly string $rest_api_url,
        #[DataCollectionOf(EgressWebhookItemDTO::class)]
        public readonly ?DataCollection $egress_webhooks = null,
        #[DataCollectionOf(EgressLogItemDTO::class)]
        public readonly ?DataCollection $recent_egress_logs = null,
    ) {}
}
