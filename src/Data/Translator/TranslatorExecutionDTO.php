<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Translator;

use InvalidArgumentException;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class TranslatorExecutionDTO extends Data
{
    /**
     * @param  string|array<int, string>  $content_to_translate
     */
    public function __construct(
        #[UI(label: 'Target Language', component: UiComponent::Select, options: ['es' => 'Spanish', 'en' => 'English', 'fr' => 'French', 'de' => 'German', 'pt' => 'Portuguese'])]
        public readonly string $target_language,

        #[UI(label: 'Forbidden Words', component: UiComponent::Textarea, placeholder: 'Comma-separated words to avoid')]
        public readonly ?string $forbidden_words,

        #[UI(label: 'Content to Translate', component: UiComponent::Textarea, placeholder: 'Paste text to translate')]
        public readonly string|array $content_to_translate,

        #[UI(label: 'File Path', component: UiComponent::Text, placeholder: '/path/to/file', hidden: true)]
        public readonly ?string $file_path = null,
    ) {}

    /**
     * Assembles the DTO from the agent's persisted config and the task's runtime payload.
     *
     * @param  array{target_language: string, forbidden_words?: string|null}  $agentConfig
     * @param  array{content_to_translate: string|array<int, string>, file_path?: string|null}  $taskPayload
     */
    public static function assemble(array $agentConfig, array $taskPayload): self
    {
        if (! isset($agentConfig['target_language'])) {
            throw new InvalidArgumentException('agentConfig must include [target_language].');
        }

        if (! isset($taskPayload['content_to_translate'])) {
            throw new InvalidArgumentException('taskPayload must include [content_to_translate].');
        }

        return new self(
            target_language: $agentConfig['target_language'],
            forbidden_words: $agentConfig['forbidden_words'] ?? null,
            content_to_translate: $taskPayload['content_to_translate'],
            file_path: $taskPayload['file_path'] ?? null,
        );
    }

    /**
     * Normaliza el contenido a string para el prompt LLM.
     */
    public function contentAsString(): string
    {
        if (is_array($this->content_to_translate)) {
            return implode("\n---\n", $this->content_to_translate);
        }

        return $this->content_to_translate;
    }

    public function isArrayInput(): bool
    {
        return is_array($this->content_to_translate);
    }
}
