<?php

namespace Chipneedham\LaravelGovee;

use Illuminate\Support\Facades\Facade;

class GoveeFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'govee-api';
    }
}