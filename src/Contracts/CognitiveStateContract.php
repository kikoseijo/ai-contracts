<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Contracts;

use Sunnyface\Contracts\Data\Llm\CognitiveContextDTO;

/**
 * Contrato para el gestor de estado cognitivo.
 *
 * Define el ciclo freeze → thaw → flush que permite a los Jobs recibir
 * solo el $taskId (Claim Check Pattern) y reconstruir el contexto completo
 * desde Redis (caché en caliente) o PostgreSQL (respaldo).
 *
 * Implementaciones:
 *   - Hub:  App\Services\Llm\CognitiveStateManager
 *   - Test: Implementación in-memory para feature tests
 */
interface CognitiveStateContract
{
    /**
     * Serializa el DTO a Redis con un TTL.
     * Se llama al inicio del Job, justo antes de lanzar el pipeline.
     */
    public function freeze(CognitiveContextDTO $context, int $ttlSeconds = 3600): void;

    /**
     * Reconstruye el DTO desde Redis (o PostgreSQL como fallback).
     * Se llama al inicio del handle() del Job.
     *
     * @throws \RuntimeException Si el estado no existe ni en Redis ni en DB.
     */
    public function thaw(string $taskId): CognitiveContextDTO;

    /**
     * Escribe el estado final del DTO al modelo Task en PostgreSQL
     * y elimina la clave de Redis. Único write a DB en todo el pipeline.
     * Se llama al final del handle() del Job, tras el pipeline completo.
     */
    public function flush(CognitiveContextDTO $context): void;

    /**
     * Elimina el estado de Redis sin escribir a DB.
     * Útil en tests y en casos de cancelación de tarea.
     */
    public function forget(string $taskId): void;
}
