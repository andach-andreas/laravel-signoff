<?php

namespace Andach\LaravelSignoff\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Andach\LaravelSignoff\LaravelSignoff
 */
class LaravelSignoff extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Andach\LaravelSignoff\LaravelSignoff::class;
    }
}
