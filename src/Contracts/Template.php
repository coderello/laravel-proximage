<?php

namespace Coderello\Proximage\Contracts;

use Coderello\Proximage\ImageProxy;

interface Template
{
    public function handle(ImageProxy $proximage);
}
