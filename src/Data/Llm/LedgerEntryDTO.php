<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Llm;

use Spatie\LaravelData\Data;

final class LedgerEntryDTO extends Data
{
    public function __construct(
        public readonly string $status,
        /**
         * Unix epoch en **segundos** con parte fraccionaria (misma semántica que `microtime(true)` en PHP).
         * No milisegundos: en JS el instante es `new Date(ts * 1000)` (convención Date de milisegundos).
         */
        public readonly float $timestamp,
        /** Duración desde la transición anterior, en milisegundos (métrica, no instante). */
        public readonly float $duration_ms,
    ) {}
}
