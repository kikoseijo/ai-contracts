<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum VaultType: string
{
    case Raw = 'raw';
    case Rag = 'rag';
    case Extraction = 'extraction';
    case Classification = 'classification';

    public function label(): string
    {
        return match ($this) {
            self::Raw => 'Almacenamiento Directo',
            self::Rag => 'RAG (Búsqueda Semántica)',
            self::Extraction => 'Extracción de Datos',
            self::Classification => 'Clasificación de Documentos',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Raw => 'Almacena documentos sin procesar. Ideal para archivos que solo necesitan estar disponibles para descarga.',
            self::Rag => 'Indexa documentos para búsqueda semántica con embeddings vectoriales. Usa esto para bases de conocimiento y chatbots.',
            self::Extraction => 'Extrae datos estructurados de documentos (facturas, contratos, formularios) usando visión AI.',
            self::Classification => 'Clasifica automáticamente documentos por tipo y contenido usando modelos de lenguaje.',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Raw => 'document-text',
            self::Rag => 'magnifying-glass-circle',
            self::Extraction => 'table-cells',
            self::Classification => 'tag',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Raw => 'zinc',
            self::Rag => 'green',
            self::Extraction => 'blue',
            self::Classification => 'amber',
        };
    }
}
