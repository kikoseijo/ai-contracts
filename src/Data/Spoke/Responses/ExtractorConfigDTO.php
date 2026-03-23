<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\ExtractorTemplate;

/**
 * Configuración del extractor de un agente (objeto embebido en la respuesta de updateExtractorConfig).
 */
final class ExtractorConfigDTO extends Data
{
    public function __construct(
        public readonly ?ExtractorTemplate $extractor_template,
        public readonly bool $strict_mode,
        public readonly bool $store_in_vault,
        public readonly ?string $fallback_email,
        public readonly bool $email_only_on_error,
    ) {}
}
