<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

/**
 * Tipo de contenido de un documento en una bóveda de conocimiento.
 */
enum VaultDocumentType: string
{
    case Document = 'document';
    case Audio = 'audio';
    case Image = 'image';
    case Text = 'text';
}
