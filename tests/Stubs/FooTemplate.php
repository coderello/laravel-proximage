<?php

namespace Coderello\Proximage\Tests\Stubs;

use Coderello\Proximage\ImageProxy;
use Coderello\Proximage\Contracts\Template;

class FooTemplate implements Template
{
    public function handle(ImageProxy $proximage)
    {
        $proximage->parameter('foo', 'bar');
    }
}
