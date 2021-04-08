<?php

namespace Captenmasin\LaravelViewWith;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Captenmasin\LaravelViewWith\LaravelViewWith
 */
class LaravelViewWithFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-view-with';
    }
}
