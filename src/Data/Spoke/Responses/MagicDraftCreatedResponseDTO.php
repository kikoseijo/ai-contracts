<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;

/**
 * Respuesta canónica tras generar la configuración de agente con IA (MagicDraft).
 */
final class MagicDraftCreatedResponseDTO extends Data
{
    /**
     * @param  array<string, mixed>|null  $intent_analysis
     */
    public function __construct(
        public readonly string $suggested_name,
        public readonly string $suggested_greeting,
        public readonly string $custom_instructions,
        public readonly ?array $intent_analysis,
    ) {}

    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return 201;
    }


    /**
     * @return array{status: string, draft: array{suggested_name: string, suggested_greeting: string, custom_instructions: string, intent_analysis: array<string, mixed>|null}}
     */
    public function toArray(): array
    {
        return [
            'status' => 'drafted',
            'draft' => [
                'suggested_name' => $this->suggested_name,
                'suggested_greeting' => $this->suggested_greeting,
                'custom_instructions' => $this->custom_instructions,
                'intent_analysis' => $this->intent_analysis,
            ],
        ];
    }
}
