<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AppService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\AppService::class;
    }
}