<?php

namespace Accentinteractive\LaravelSso;

use Accentinteractive\LaravelSso\Commands\Logcleaner;
use Illuminate\Support\ServiceProvider;

class LaravelSsoServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/sso.php' => config_path('sso.php'),
        ], 'config');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-sso'),
        ], 'lang');*/
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sso.php', 'sso');

        $this->app->bind('command.sso:run', Logcleaner::class);

        $this->commands([
            'command.sso:run',
        ]);
    }
}
