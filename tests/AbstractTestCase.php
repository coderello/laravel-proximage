<?php

namespace Coderello\Proximage\Tests;

use Coderello\Proximage\Providers\ProximageServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class AbstractTestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ProximageServiceProvider::class,
        ];
    }
}
