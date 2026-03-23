<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Extractor;

use InvalidArgumentException;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Attributes\UI;
use Sunnyface\Contracts\Enums\UiComponent;

class ExtractorExecutionDTO extends Data
{
    /**
     * @param  string|null  $file_path  Path en R2 (flujo clásico desde el Hub)
     * @param  string|null  $file_base64  Contenido codificado en Base64 (flujo Spoke directo)
     * @param  string|null  $file_mime  MIME type requerido cuando se usa file_base64
     * @param  string|null  $schema_slug  Slug del TaskSchema pre-asignado desde la config del Agente. Si se indica, se salta la clasificación LLM.
     */
    public function __construct(
        #[UI(label: 'Documento', component: UiComponent::File, placeholder: 'PDF o imagen de la factura')]
        public readonly ?string $file_path = null,

        public readonly ?string $file_base64 = null,

        public readonly ?string $file_mime = null,

        #[UI(label: 'Modo Estricto', component: UiComponent::Toggle, description: 'La IA falla si algún campo requerido falta en el documento. Recomendado para flujos automatizados.')]
        public readonly bool $strict_mode = false,

        public readonly ?string $schema_slug = null,
    ) {}

    /**
     * @param  array{strict_mode?: bool, schema_slug?: string, fallback_to_human?: bool}  $agentConfig
     * @param  array{
     *     file_path?: string,
     *     file_base64?: string,
     *     file_mime?: string,
     *     strict_mode?: bool,
     *     files?: list<array<string, mixed>|mixed>|array<string, array<string, mixed>>
     * }  $taskPayload
     */
    public static function assemble(array $agentConfig, array $taskPayload): self
    {
        $taskPayload = self::expandFilesFromPayload($taskPayload);

        $hasFilePath = isset($taskPayload['file_path']) && $taskPayload['file_path'] !== '';
        $hasBase64 = isset($taskPayload['file_base64']) && $taskPayload['file_base64'] !== '';

        if (! $hasFilePath && ! $hasBase64) {
            throw new InvalidArgumentException(
                'taskPayload must include either [file_path] or [file_base64 + file_mime], or a non-empty [files] array whose first item provides one of those.',
            );
        }

        if ($hasBase64 && (! isset($taskPayload['file_mime']) || $taskPayload['file_mime'] === '')) {
            throw new InvalidArgumentException(
                'taskPayload must include [file_mime] when using [file_base64].',
            );
        }

        return new self(
            file_path: $taskPayload['file_path'] ?? null,
            file_base64: $taskPayload['file_base64'] ?? null,
            file_mime: $taskPayload['file_mime'] ?? null,
            strict_mode: (bool) ($taskPayload['strict_mode'] ?? $agentConfig['strict_mode'] ?? false),
            schema_slug: $agentConfig['schema_slug'] ?? null,
        );
    }

    /**
     * Spoke / clients often send a top-level `files` array (list of file descriptors).
     * Fold the first entry into top-level keys expected by the extractor pipeline.
     *
     * @param  array<string, mixed>  $taskPayload
     * @return array<string, mixed>
     */
    private static function expandFilesFromPayload(array $taskPayload): array
    {
        $hasFilePath = isset($taskPayload['file_path']) && is_string($taskPayload['file_path']) && $taskPayload['file_path'] !== '';
        $hasBase64 = isset($taskPayload['file_base64']) && is_string($taskPayload['file_base64']) && $taskPayload['file_base64'] !== '';
        if ($hasFilePath || $hasBase64) {
            return $taskPayload;
        }

        $files = $taskPayload['files'] ?? null;
        if (! is_array($files) || $files === []) {
            return $taskPayload;
        }

        $first = array_is_list($files) ? ($files[0] ?? null) : reset($files);
        if (! is_array($first)) {
            return $taskPayload;
        }

        $pickFirstString = static function (array $row, array $keys): ?string {
            foreach ($keys as $key) {
                if (isset($row[$key]) && is_string($row[$key]) && $row[$key] !== '') {
                    return $row[$key];
                }
            }

            return null;
        };

        $path = $pickFirstString($first, ['file_path', 'path', 'r2_path', 'storage_path', 'key']);
        $b64 = $pickFirstString($first, ['file_base64', 'base64', 'content_base64', 'data']);
        $mime = $pickFirstString($first, ['file_mime', 'mime', 'mime_type', 'content_type']);

        $out = $taskPayload;
        if ($path !== null) {
            $out['file_path'] = $path;
        }
        if ($b64 !== null) {
            $out['file_base64'] = $b64;
        }
        if ($mime !== null) {
            $out['file_mime'] = $mime;
        }

        return $out;
    }
}
