<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\FinancialExtraction;

use InvalidArgumentException;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class FinancialExtractionInputDTO extends Data
{
    public function __construct(
        #[UI(label: 'Document ID (Spoke)', component: UiComponent::Text)]
        public readonly string $spoke_document_id,

        #[UI(label: 'Input Type', component: UiComponent::Select, options: ['text' => 'Text', 'audio' => 'Audio', 'file' => 'File'])]
        public readonly string $input_type,

        #[UI(label: 'Raw Text', component: UiComponent::Textarea)]
        public readonly ?string $raw_text = null,

        #[UI(label: 'File URL (Presigned)', component: UiComponent::Text, placeholder: 'https://...')]
        public readonly ?string $file_url = null,

        #[UI(label: 'Strict Mode', component: UiComponent::Toggle)]
        public readonly bool $strict_mode = true,
    ) {}

    /**
     * @param  array{strict_mode?: bool}  $agentConfig
     * @param  array{spoke_document_id: string, input_type: string, raw_text?: string|null, file_url?: string|null}  $taskPayload
     */
    public static function assemble(array $agentConfig, array $taskPayload): self
    {
        if (! isset($taskPayload['spoke_document_id'], $taskPayload['input_type'])) {
            throw new InvalidArgumentException('taskPayload must include [spoke_document_id] and [input_type].');
        }

        $inputType = $taskPayload['input_type'];

        if ($inputType === 'text' && empty($taskPayload['raw_text'])) {
            throw new InvalidArgumentException('input_type=text requires [raw_text].');
        }

        if (in_array($inputType, ['file', 'audio'], true) && empty($taskPayload['file_url'])) {
            throw new InvalidArgumentException("input_type={$inputType} requires [file_url].");
        }

        return new self(
            spoke_document_id: $taskPayload['spoke_document_id'],
            input_type: $inputType,
            raw_text: $taskPayload['raw_text'] ?? null,
            file_url: $taskPayload['file_url'] ?? null,
            strict_mode: (bool) ($agentConfig['strict_mode'] ?? false),
        );
    }
}
