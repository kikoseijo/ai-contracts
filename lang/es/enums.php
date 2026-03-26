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
];