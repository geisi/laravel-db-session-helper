<?php

namespace Geisi\LaravelDbSessionHelper;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Geisi\LaravelDbSessionHelper\LaravelDbSessionHelper
 */
class LaravelDbSessionHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-db-session-helper';
    }
}
