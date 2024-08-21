<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Example extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return \App\Helpers\Example::class;
    }
}
