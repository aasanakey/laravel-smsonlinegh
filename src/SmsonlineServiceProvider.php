<?php

namespace Aasanakey\Smsonline;

use Illuminate\Support\ServiceProvider;
use Aasanakey\Smsonline\SMS;
use Aasanakey\Smsonline\SmsonlineChannel;
use Illuminate\Support\Facades\Notification;

class SmsonlineServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
         //Make config publishment optional by merging the config from the package.
        $this->mergeConfigFrom(
            __DIR__.'/../config/smsonline.php', 'smsonline'
        );

        Notification::extend('smsonlinegh', function ($app) {
            return new SmsonlineChannel();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/smsonline.php' => config_path('smsonline.php'),
        ],'smsonline-config');

        $this->app->bind('smsonline-sms', function () {
            return new SMS();
        });
    }
}
