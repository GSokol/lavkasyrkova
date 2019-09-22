<?php

namespace Illuminate\Support\Facades;

class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
}