<?php

use Sunnyface\Contracts\Data\Spoke\Responses\ProvisionTenantResponseDTO;
use Sunnyface\Contracts\Enums\SpokeOperationStatus;

it('returns swarm agent IDs for talker, extractor, and drafter', function () {
    $dto = new ProvisionTenantResponseDTO(
        status: SpokeOperationStatus::Provisioned,
        tenant_id: '01JARZ5B4KEXAMPLE00000TEST',
        talker_agent_id: '01JARZ5B4KTALKER0000TEST',
        extractor_agent_id: '01JARZ5B4KEXTRACT000TEST',
        drafter_agent_id: '01JARZ5B4KDRAFTER000TEST',
        default_vault_id: '01JARZ5B4KVAULT0000TEST',
    );

    expect($dto->talker_agent_id)->toBe('01JARZ5B4KTALKER0000TEST')
        ->and($dto->extractor_agent_id)->toBe('01JARZ5B4KEXTRACT000TEST')
        ->and($dto->drafter_agent_id)->toBe('01JARZ5B4KDRAFTER000TEST')
        ->and($dto->default_vault_id)->toBe('01JARZ5B4KVAULT0000TEST')
        ->and($dto->calculateResponseStatus(request()))->toBe(201);
});

it('allows default_vault_id to be null', function () {
    $dto = new ProvisionTenantResponseDTO(
        status: SpokeOperationStatus::Provisioned,
        tenant_id: '01JARZ5B4KEXAMPLE00000TEST',
        talker_agent_id: '01JARZ5B4KTALKER0000TEST',
        extractor_agent_id: '01JARZ5B4KEXTRACT000TEST',
        drafter_agent_id: '01JARZ5B4KDRAFTER000TEST',
    );

    expect($dto->default_vault_id)->toBeNull();
});
