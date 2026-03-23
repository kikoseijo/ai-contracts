<?php

declare(strict_types=1);

namespace Sunnyface\Contracts;

use Illuminate\Support\ServiceProvider;

class AiContractsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registro de bindings si los DTOs necesitan resolución de dependencias
    }

    public function boot(): void
    {
        // Publicación de configuraciones si el paquete crece
    }
}
