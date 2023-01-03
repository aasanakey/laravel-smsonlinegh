<?php

namespace Aasanakey\Smsonline;

use Illuminate\Support\ServiceProvider;
use Aasanakey\Smsonline\SMS;

class SmsonlineServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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
