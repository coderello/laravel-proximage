<?php

namespace Coderello\Proximage\Templates;

use Coderello\Proximage\Contracts\Template;
use Coderello\Proximage\Enums\Parameter\CropAlignment;
use Coderello\Proximage\Enums\Parameter\Mask;
use Coderello\Proximage\Enums\Parameter\Output;
use Coderello\Proximage\ImageProxy;

class AvatarTemplate implements Template
{
    public function handle(ImageProxy $proximage)
    {
        $proximage->crop(CropAlignment::ENTROPY)
            ->mask(Mask::CIRCLE)
            ->output(Output::PNG)
            ->maskTrim(true);
    }
}
