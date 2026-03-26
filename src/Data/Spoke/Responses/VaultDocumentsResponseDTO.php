<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Data\Network\VaultDocumentItemDTO;
use Sunnyface\Contracts\Data\Network\VaultItemDTO;

/**
 * Respuesta del Hub al solicitar los documentos de una bóveda.
 */
final class VaultDocumentsResponseDTO extends Data
{
    public function __construct(
        public readonly VaultItemDTO $vault,
        /** @var array<int, VaultDocumentItemDTO>|null */
        public readonly ?array $documents = null,
    ) {}

}
