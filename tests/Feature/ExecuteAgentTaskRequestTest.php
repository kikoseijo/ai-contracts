<?php

use Sunnyface\Contracts\Data\Spoke\ExecuteAgentTaskRequest;
use Sunnyface\Contracts\Data\Spoke\Payloads\ConversationalPayloadDTO;

it('requires task_type and accepts nullable tenant_agent_id', function () {
    $dto = ExecuteAgentTaskRequest::from([
        'tenant_id' => '01JARZ5B4KEXAMPLE00000TEST',
        'task_type' => 'conversation',
        'payload' => [
            'type' => 'conversational',
            'message' => 'Hola mundo',
        ],
    ]);

    expect($dto->task_type)->toBe('conversation')
        ->and($dto->tenant_agent_id)->toBeNull()
        ->and($dto->payload)->toBeInstanceOf(ConversationalPayloadDTO::class);
});

it('accepts an explicit tenant_agent_id when provided', function () {
    $dto = ExecuteAgentTaskRequest::from([
        'tenant_id' => '01JARZ5B4KEXAMPLE00000TEST',
        'task_type' => 'conversation',
        'payload' => [
            'type' => 'conversational',
            'message' => 'Hola mundo',
        ],
        'tenant_agent_id' => '01JARZ5B4KAGENT000000TEST',
    ]);

    expect($dto->tenant_agent_id)->toBe('01JARZ5B4KAGENT000000TEST');
});
