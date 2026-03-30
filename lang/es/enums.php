<?php

return [
    'handlers' => [
        'talker' => [
            'label' => 'Conversacional (Talker)',
            'description' => 'Agente conversacional de propósito general capaz de mantener diálogos fluidos y usar la bóveda de conocimiento.',
        ],
        'financial-advisor' => [
            'label' => 'Asesor Financiero (Agentic)',
            'description' => 'Agente especializado en análisis financiero, capaz de ejecutar herramientas complejas y consultar normativas.',
        ],
        'customs-advisor' => [
            'label' => 'Asesor de Aduanas (Agentic)',
            'description' => 'Agente experto en normativas aduaneras, aranceles y procesos de importación/exportación.',
        ],
        'text-translator' => [
            'label' => 'Traductor de Texto',
            'description' => 'Agente diseñado para traducir textos con alta precisión manteniendo el contexto y tono original.',
        ],
        'vision-extractor' => [
            'label' => 'Extractor Visual',
            'description' => 'Agente capaz de analizar imágenes y documentos escaneados para extraer información estructurada.',
        ],
        'document-classifier' => [
            'label' => 'Clasificador de Documentos',
            'description' => 'Agente que analiza el contenido de un documento y lo categoriza según una taxonomía predefinida.',
        ],
        'financial-extractor' => [
            'label' => 'Extractor Financiero',
            'description' => 'Agente especializado en extraer datos estructurados (totales, impuestos, líneas) de facturas y tickets.',
        ],
        'meta-agent' => [
            'label' => 'Meta-Agente del Sistema',
            'description' => 'Orquestador central que enruta las peticiones al agente especializado más adecuado.',
        ],
        'vault-ingest' => [
            'label' => 'Ingesta de Bóveda',
            'description' => 'Proceso de fondo encargado de vectorizar y almacenar documentos en la base de conocimiento.',
        ],
    ],
    'vision_extractor_schemas' => [
        'financial-document' => [
            'label' => 'Factura / Ticket / Presupuesto',
            'description' => 'Documentos financieros: facturas, tickets de compra, presupuestos y notas de crédito.',
        ],
        'payslip' => [
            'label' => 'Nómina / Jaaropgave',
            'description' => 'Nóminas de empleados, resúmenes anuales fiscales (jaaropgave) y recibos de salario.',
        ],
    ],
    'vault_types' => [
        'raw' => [
            'label' => 'Almacenamiento Directo',
            'description' => 'Almacena documentos sin procesar. Ideal para archivos que solo necesitan estar disponibles para descarga.',
        ],
        'rag' => [
            'label' => 'RAG (Búsqueda Semántica)',
            'description' => 'Indexa documentos para búsqueda semántica con embeddings vectoriales. Usa esto para bases de conocimiento y chatbots.',
        ],
        'extraction' => [
            'label' => 'Extracción de Datos',
            'description' => 'Extrae datos estructurados de documentos (facturas, contratos, formularios) usando visión AI.',
        ],
        'classification' => [
            'label' => 'Clasificación de Documentos',
            'description' => 'Clasifica automáticamente documentos por tipo y contenido usando modelos de lenguaje.',
        ],
    ],
    'vault_document_types' => [
        'document' => 'Documento',
        'audio' => 'Audio',
        'image' => 'Imagen',
        'text' => 'Texto Plano',
    ],
    'log_levels' => [
        'info' => 'Información',
        'warning' => 'Advertencia',
        'error' => 'Error',
        'critical' => 'Crítico',
    ],
];