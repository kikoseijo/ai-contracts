<?php

return [
    'handlers' => [
        'talker' => [
            'label' => 'Conversational (Talker)',
            'description' => 'General-purpose conversational agent capable of maintaining fluid dialogues and using the knowledge vault.',
        ],
        'financial-advisor' => [
            'label' => 'Financial Advisor (Agentic)',
            'description' => 'Agent specialized in financial analysis, capable of executing complex tools and consulting regulations.',
        ],
        'customs-advisor' => [
            'label' => 'Customs Advisor (Agentic)',
            'description' => 'Agent expert in customs regulations, tariffs, and import/export processes.',
        ],
        'text-translator' => [
            'label' => 'Text Translator',
            'description' => 'Agent designed to translate texts with high precision while maintaining the original context and tone.',
        ],
        'vision-extractor' => [
            'label' => 'Vision Extractor',
            'description' => 'Agent capable of analyzing images and scanned documents to extract structured information.',
        ],
        'document-classifier' => [
            'label' => 'Document Classifier',
            'description' => 'Agent that analyzes document content and categorizes it according to a predefined taxonomy.',
        ],
        'financial-extractor' => [
            'label' => 'Financial Extractor',
            'description' => 'Agent specialized in extracting structured data (totals, taxes, line items) from invoices and receipts.',
        ],
        'meta-agent' => [
            'label' => 'System Meta-Agent',
            'description' => 'Central orchestrator that routes requests to the most appropriate specialized agent.',
        ],
        'vault-ingest' => [
            'label' => 'Vault Ingestion',
            'description' => 'Background process responsible for vectorizing and storing documents in the knowledge base.',
        ],
    ],
];