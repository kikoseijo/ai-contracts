<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Un TaskSchema expuesto al Spoke en el listado por handler.
 */
final class TaskSchemaItemDTO extends Data
{
    public function __construct(
        public readonly string $slug,
        public readonly string $name,
        public readonly ?string $description,
        /** @var array<string, mixed>|null */
        public readonly ?array $input_schema,
        /** @var array<string, mixed>|null */
        public readonly ?array $output_schema,
        public readonly bool $is_public,
    ) {}
}
