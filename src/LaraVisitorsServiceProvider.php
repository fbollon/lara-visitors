<?php

namespace Fbollon\LaraVisitors;

use Illuminate\Support\ServiceProvider;

class LaraVisitorsServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravisitors');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'laravisitors');

        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/laravisitors.php' => config_path('laravisitors.php'),
        ], 'laravisitors-config');

        // Publish assets
        $this->publishes([
            __DIR__.'/../public/vendor/laravisitors' => public_path('vendor/laravisitors'),
        ], 'laravisitors-assets');

        // Publish the minimal layout
        $this->publishes([
            __DIR__.'/../resources/views/layouts/minimal.blade.php' => resource_path('views/vendor/laravisitors/layouts/minimal.blade.php'),
        ], 'laravisitors-layout');

        // Allow publishing for override on host application side
        $this->publishes([
            __DIR__.'/../lang' => lang_path('vendor/laravisitors'),
        ], 'laravisitors-translations');

        // Define custom middleware
        $this->app['router']->aliasMiddleware('laravisitors.access', \Fbollon\LaraVisitors\Http\Middleware\LaraVisitorsAccess::class);

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravisitors.php', 'laravisitors');
    }
}
