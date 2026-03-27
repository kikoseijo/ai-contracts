<?php

use Sunnyface\Contracts\Data\Spoke\Responses\ProvisionTenantResponseDTO;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

it('returns a single default_agent_id after provisioning', function () {
    $dto = new ProvisionTenantResponseDTO(
        status: SpokeOperationStatus::Provisioned,
        tenant_id: '01JARZ5B4KEXAMPLE00000TEST',
        default_agent_id: '01JARZ5B4KAGENT0000TEST',
        default_vault_id: '01JARZ5B4KVAULT0000TEST',
    );

    expect($dto->default_agent_id)->toBe('01JARZ5B4KAGENT0000TEST')
        ->and($dto->default_vault_id)->toBe('01JARZ5B4KVAULT0000TEST')
        ->and($dto->calculateResponseStatus(request()))->toBe(201);
});

it('allows default_vault_id to be null', function () {
    $dto = new ProvisionTenantResponseDTO(
        status: SpokeOperationStatus::Provisioned,
        tenant_id: '01JARZ5B4KEXAMPLE00000TEST',
        default_agent_id: '01JARZ5B4KAGENT0000TEST',
    );

    expect($dto->default_vault_id)->toBeNull();
});
