<?php

namespace Illuminate\Support\Facades;

class Helper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'helper';
    }
}