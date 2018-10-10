<?php

namespace Coderello\Proximage\Tests;

use Coderello\Proximage\ImageProxy;

class ProximageHelperTest extends AbstractTestCase
{
    public function test_returns_appropriate_object()
    {
        $this->assertInstanceOf(
            ImageProxy::class,
            proximage()
        );
    }

    public function test_passing_url_as_the_first_argument_is_the_same_as_passing_it_to_the_chained_url_method()
    {
        $this->assertSame(
            (string) proximage('http://example.com'),
            (string) proximage()->url('http://example.com')
        );
    }
}
