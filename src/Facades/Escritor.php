<?php

namespace Escritor\Facades;

use Illuminate\Support\Facades\Facade;

class Escritor extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'escritor';
    }
}