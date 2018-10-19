<?php

namespace Coderello\Proximage\Tests\Stubs;

use Coderello\Proximage\Contracts\Template;
use Coderello\Proximage\ImageProxy;

class FooTemplate implements Template
{
    public function handle(ImageProxy $proximage)
    {
        $proximage->parameter('foo', 'bar');
    }
}
