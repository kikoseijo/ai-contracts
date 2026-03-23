<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum ExtractorTemplate: string
{
    case Generic = 'generic';
    case Invoice = 'invoice';
    case Receipt = 'receipt';
    case IdCard = 'id_card';

    public function label(): string
    {
        return match ($this) {
            self::Generic => 'Genérico — Extracción libre',
            self::Invoice => 'Factura — Datos fiscales y líneas',
            self::Receipt => 'Recibo — Importes y conceptos',
            self::IdCard => 'Documento de identidad — Datos personales',
        };
    }

    /**
     * OpenAI structured-output schema for this extraction template.
     *
     * @return array<string, mixed>
     */
    public function getSchema(): array
    {
        return match ($this) {
            self::Invoice => [
                'name' => 'invoice_extraction',
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'vendor_name' => ['type' => ['string', 'null']],
                        'invoice_number' => ['type' => ['string', 'null']],
                        'issue_date' => ['type' => ['string', 'null'], 'description' => 'ISO 8601 YYYY-MM-DD'],
                        'total_amount' => ['type' => ['number', 'null']],
                        'currency' => ['type' => ['string', 'null'], 'description' => 'ISO 4217'],
                        'line_items' => [
                            'type' => ['array', 'null'],
                            'items' => ['type' => 'string'],
                        ],
                    ],
                    'required' => ['vendor_name', 'invoice_number', 'issue_date', 'total_amount', 'currency', 'line_items'],
                    'additionalProperties' => false,
                ],
                'strict' => true,
            ],
            self::Receipt => [
                'name' => 'receipt_extraction',
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'merchant_name' => ['type' => ['string', 'null']],
                        'date' => ['type' => ['string', 'null'], 'description' => 'ISO 8601 YYYY-MM-DD'],
                        'total_amount' => ['type' => ['number', 'null']],
                        'currency' => ['type' => ['string', 'null'], 'description' => 'ISO 4217'],
                        'payment_method' => ['type' => ['string', 'null']],
                        'items' => [
                            'type' => ['array', 'null'],
                            'items' => ['type' => 'string'],
                        ],
                    ],
                    'required' => ['merchant_name', 'date', 'total_amount', 'currency', 'payment_method', 'items'],
                    'additionalProperties' => false,
                ],
                'strict' => true,
            ],
            self::IdCard => [
                'name' => 'id_card_extraction',
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'full_name' => ['type' => ['string', 'null']],
                        'document_number' => ['type' => ['string', 'null']],
                        'date_of_birth' => ['type' => ['string', 'null'], 'description' => 'ISO 8601 YYYY-MM-DD'],
                        'expiry_date' => ['type' => ['string', 'null'], 'description' => 'ISO 8601 YYYY-MM-DD'],
                        'nationality' => ['type' => ['string', 'null']],
                        'issuing_country' => ['type' => ['string', 'null'], 'description' => 'ISO 3166-1 alpha-2'],
                    ],
                    'required' => ['full_name', 'document_number', 'date_of_birth', 'expiry_date', 'nationality', 'issuing_country'],
                    'additionalProperties' => false,
                ],
                'strict' => true,
            ],
            self::Generic => [
                'name' => 'generic_extraction',
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'document_type' => ['type' => 'string', 'description' => 'Tipo de documento detectado'],
                        'summary' => ['type' => 'string', 'description' => 'Resumen ejecutivo del contenido'],
                        'key_fields' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'field' => ['type' => 'string'],
                                    'value' => ['type' => 'string'],
                                ],
                                'required' => ['field', 'value'],
                                'additionalProperties' => false,
                            ],
                        ],
                    ],
                    'required' => ['document_type', 'summary', 'key_fields'],
                    'additionalProperties' => false,
                ],
                'strict' => true,
            ],
        };
    }
}
