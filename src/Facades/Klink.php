<?php

namespace KilroyWeb\Klink\Facades;

use Illuminate\Support\Facades\Facade;

class Klink extends Facade
{
    protected static function getFacadeAccessor() {
        return 'klink';
    }
}
