<?php

use Sunnyface\Contracts\Data\Spoke\Responses\WidgetChatEnqueuedResponseDTO;
use Sunnyface\Contracts\Data\Spoke\Responses\ApiErrorResponseDTO;

it('returns strictly 202 for WidgetChatEnqueuedResponseDTO', function () {
    $dto = new WidgetChatEnqueuedResponseDTO('task-123');
    expect($dto->calculateResponseStatus(request()))->toBe(202);
});

it('returns strictly 403 for ApiErrorResponseDTO when given 403', function () {
    $dto = new ApiErrorResponseDTO('Forbidden', 403);
    expect($dto->calculateResponseStatus(request()))->toBe(403);
});
