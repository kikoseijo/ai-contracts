<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Classifier;

use InvalidArgumentException;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\ClassifierPriority;
use Sunnyface\Contracts\Enums\UiComponent;

class ClassifierExecutionDTO extends Data
{
    /**
     * @param  array<int, string>  $allowed_categories
     */
    public function __construct(
        #[UI(label: 'Allowed Categories', component: UiComponent::Tags)]
        public readonly array $allowed_categories,

        #[UI(label: 'Default Priority', component: UiComponent::Select, options: ['low' => 'Low', 'normal' => 'Normal', 'high' => 'High', 'urgent' => 'Urgent'])]
        public readonly ClassifierPriority $default_priority,

        #[UI(label: 'Content to Classify', component: UiComponent::Textarea, placeholder: 'Paste the text to classify')]
        public readonly string $content_to_classify,
    ) {}

    /**
     * @param  array{allowed_categories: array<int, string>, default_priority?: string}  $agentConfig
     * @param  array{content_to_classify: string}  $taskPayload
     */
    public static function assemble(array $agentConfig, array $taskPayload): self
    {
        if (! isset($agentConfig['allowed_categories']) || ! is_array($agentConfig['allowed_categories'])) {
            throw new InvalidArgumentException('agentConfig must include [allowed_categories] as array.');
        }

        if (! isset($taskPayload['content_to_classify'])) {
            throw new InvalidArgumentException('taskPayload must include [content_to_classify].');
        }

        return new self(
            allowed_categories: $agentConfig['allowed_categories'],
            default_priority: ClassifierPriority::from($agentConfig['default_priority'] ?? 'normal'),
            content_to_classify: $taskPayload['content_to_classify'],
        );
    }
}
