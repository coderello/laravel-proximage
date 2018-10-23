<?php

namespace Coderello\Proximage\Tests;

use Coderello\Proximage\ImageProxy;
use Coderello\Proximage\Facades\Proximage;

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
