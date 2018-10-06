<?php

namespace Coderello\Proximage\Facades;

use Illuminate\Support\Facades\Facade;

class Proximage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'proximage';
    }
}
