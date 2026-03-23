<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Llm;

use Spatie\LaravelData\Data;

/**
 * Registro inmutable de una invocación a herramienta (tool calling) durante el razonamiento del agente.
 *
 * Se acumula en {@see CognitiveContextDTO::$toolExecutions} y persiste en Hub vía flush.
 */
final class ToolExecutionDTO extends Data
{
    public function __construct(
        public readonly string $toolName,
        /** @var array<string, mixed> */
        public readonly array $arguments,
        public readonly mixed $result,
        public readonly float $durationMs,
        public readonly ?string $errorMessage = null,
    ) {}

    public function hasError(): bool
    {
        return $this->errorMessage !== null && $this->errorMessage !== '';
    }
}
