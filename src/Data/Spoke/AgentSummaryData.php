<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\HandlerSlug;

class AgentSummaryData extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name,
        public readonly HandlerSlug $handler_slug,
        public readonly bool $is_active,
        public readonly ?string $webhook_url,
        public readonly bool $webhook_active,
        public readonly string $created_at,
        /** @var array<string, mixed>|null */
        public readonly ?array $configuration = null,
        public readonly ?UiManifestData $ui_manifest = null,
    ) {}
}
