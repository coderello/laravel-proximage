<?php

namespace Coderello\Proximage\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Coderello\Proximage\Providers\ProximageServiceProvider;

abstract class AbstractTestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ProximageServiceProvider::class,
        ];
    }
}
