<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

/**
 * Respuesta canónica con el estado de cuota actual de un tenant.
 */
final class QuotaResponseDTO extends Data
{
    public function __construct(
        public readonly int $available_tokens,
        public readonly int $total_vaults_allowed,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json($this);
    }

    /**
     * @return array{quota: array{available_tokens: int, total_vaults_allowed: int}}
     */
    public function toArray(): array
    {
        return [
            'quota' => [
                'available_tokens' => $this->available_tokens,
                'total_vaults_allowed' => $this->total_vaults_allowed,
            ],
        ];
    }
}
