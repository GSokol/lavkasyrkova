<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SettingsFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
}
