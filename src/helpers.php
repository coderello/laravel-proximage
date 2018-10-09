<?php

use Coderello\Proximage\ImageProxy;

if (! function_exists('proximage')) {
    function proximage(?string $url = null): ImageProxy
    {
        /** @var ImageProxy $imageProxy */
        $imageProxy = app('proximage');

        return $imageProxy->url($url);
    }
}
