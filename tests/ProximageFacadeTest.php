<?php

namespace Coderello\Proximage\Tests;

use Coderello\Proximage\Facades\Proximage;
use Coderello\Proximage\ImageProxy;

class ProximageFacadeTest extends AbstractTestCase
{
    public function test_returns_appropriate_object()
    {
        $this->assertInstanceOf(
            ImageProxy::class,
            Proximage::url('http://exmaple.com')
        );
    }
}
