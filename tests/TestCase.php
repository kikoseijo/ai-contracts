<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Sunnyface\Contracts\AiContractsServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Spatie\LaravelData\LaravelDataServiceProvider::class,
            AiContractsServiceProvider::class,
        ];
    }
}
