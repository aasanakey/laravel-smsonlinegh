<?php

namespace Aasanakey\Smsonline\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aasanakey\Smsonline\Sms
 */
class Sms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'smsonline-sms';
    }
}