<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Llm;

use Spatie\LaravelData\Data;
use Sunnyface\AiContracts\Support\RedisSafeSerialization;

/**
 * Registro inmutable de una invocación a herramienta (tool calling) durante el razonamiento del agente.
 *
 * Se acumula en {@see CognitiveContextDTO::$toolExecutions} y persiste en Hub vía flush.
 */
final class ToolExecutionDTO extends Data
{
    public function __construct(
        public private(set) string $toolName,
        /** @var array<string, mixed> */
        public private(set) array $arguments,
        public private(set) mixed $result,
        public private(set) float $durationMs,
        public private(set) ?string $errorMessage = null,
    ) {
        $this->arguments = RedisSafeSerialization::sanitize($this->arguments);
        $this->result = RedisSafeSerialization::sanitize($this->result);
    }

    public function hasError(): bool
    {
        return $this->errorMessage !== null && $this->errorMessage !== '';
    }
}
