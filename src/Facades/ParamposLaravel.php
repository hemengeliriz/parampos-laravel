<?php

namespace Hemengeliriz\ParamposLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hemengeliriz\ParamposLaravel\ParamposLaravel
 */
class ParamposLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'parampos-laravel';
    }
}
