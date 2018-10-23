<?php

namespace Coderello\Proximage\Templates;

use Coderello\Proximage\ImageProxy;
use Coderello\Proximage\Contracts\Template;

class DisableProxyingForLocalEnvironmentTemplate implements Template
{
    public function handle(ImageProxy $proximage)
    {
        $proximage->shouldProxy(function ($url) {
            return ! is_null($url)
                && ! app()->environment('local');
        });
    }
}
