<?php

use Sunnyface\Contracts\Data\Llm\CognitiveContextDTO;
use Sunnyface\Contracts\Data\Spoke\Payloads\VisionExtractorPayloadDTO;
use Sunnyface\Contracts\Enums\HandlerSlug;

it('strictly casts nested payload to VisionExtractorPayloadDTO', function () {
    $data = [
        'taskId' => 'task-123',
        'tenantId' => 'tenant-123',
        'tenantAgentId' => 'agent-123',
        'handlerSlug' => HandlerSlug::VisionExtractor->value,
        'inputPayload' => [
            'file_url' => 'https://example.com/image.jpg',
            'base64' => null,
            'mime_type' => 'image/jpeg',
            'force_schema' => null,
        ],
    ];

    $context = CognitiveContextDTO::from($data);

    expect($context->inputPayload)->toBeInstanceOf(VisionExtractorPayloadDTO::class)
        ->and($context->inputPayload->file_url)->toBe('https://example.com/image.jpg');
});
