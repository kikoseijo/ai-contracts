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
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'ai-contracts');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/ai-contracts'),
        ], 'ai-contracts-translations');
    }
}
