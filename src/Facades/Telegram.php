<?php

namespace Davletshindf\TelegramBugNotification\Facades;

use Davletshindf\TelegramBugNotification\Client;
use Illuminate\Support\Facades\Facade;
use Throwable;

/**
 * Class Client
 * @package Davletshindf\TelegramBugNotification\Facades
 * @method Client notify(Throwable $exception)
 */
class Telegram extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram';
    }
}
