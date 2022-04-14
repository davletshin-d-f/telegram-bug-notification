<?php

namespace Davletshindf\TelegramBugNotification\Providers;

use Davletshindf\TelegramBugNotification\Client;
use Davletshindf\TelegramBugNotification\Config;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $source = realpath($raw = __DIR__ . '/../../config/telegram.php') ?: $raw;

        $this->publishes([$source => config_path('telegram.php')]);

        $this->mergeConfigFrom($source, 'telegram');
    }

    public function register()
    {
        $this->app->singleton('telegram', function () {
            return new Client(new Config(config('telegram')));
        });

        $this->app->alias('telegram', Client::class);
    }
}
