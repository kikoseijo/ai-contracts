<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Ulid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Sunnyface\Contracts\Data\Spoke\SpokeToolDefinitionDTO;

/**
 * Payload que el Spoke envía al Hub para sincronizar la configuración de negocio
 * de un agente tipo Talker (nombre, saludo, instrucciones, bóvedas RAG).
 *
 * @param  array<int, string>  $vault_ids  IDs de bóvedas de conocimiento asignadas.
 * @param  DataCollection<int, SpokeToolDefinitionDTO>|null  $spoke_tools  Si es null, el Hub no altera las tools ya guardadas.
 */
final class UpdateAgentRequestDTO extends Data
{
    public function __construct(
        #[Required, Ulid]
        public readonly string $tenant_id,
        #[Required, StringType, Max(255)]
        public readonly string $name,
        #[Required, StringType, Max(1000)]
        public readonly string $greeting,
        #[Nullable, Url, Max(2048)]
        public readonly ?string $webhook_url = null,
        #[Nullable, Ulid]
        public readonly ?string $knowledge_vault_id = null,
        #[Required, StringType, Max(5000)]
        public readonly string $custom_instructions,
        /** @var array<int, string> */
        #[Required, ArrayType]
        public readonly array $vault_ids,
        #[DataCollectionOf(SpokeToolDefinitionDTO::class)]
        public readonly ?DataCollection $spoke_tools = null,
        #[Nullable, StringType, Max(5000)]
        public readonly ?string $system_prompt = null,
    ) {}
}
