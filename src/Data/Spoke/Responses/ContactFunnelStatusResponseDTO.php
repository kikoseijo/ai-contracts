<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Spoke\Responses;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;
use Sunnyface\Contracts\Enums\TaskStatus;

/**
 * Estado de tarea del funnel: en curso solo expone `status`; al terminar incluye resultados.
 *
 * @phpstan-param array<string, mixed>|null $results
 */
final class ContactFunnelStatusResponseDTO extends Data
{
    /**
     * @param  array<string, mixed>|null  $results
     */
    public function __construct(
        public readonly TaskStatus $status,
        public readonly ?array $results = null,
        public readonly mixed $error = null,
    ) {}

    public function toResponse($request): JsonResponse
    {
        if ($this->status === TaskStatus::Processing) {
            $processingPayload = ['status' => $this->status->value];

            return response()->json($processingPayload);
        }

        return response()->json($this);
    }

    /**
     * @return array{status: string, results: array<string, mixed>, error: mixed}
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status->value,
            'results' => $this->results ?? [],
            'error' => $this->error,
        ];
    }
}
