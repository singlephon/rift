<?php

namespace Singlephon\Rift;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
class RiftServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'rift');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'rift');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rift');

        Blade::component('rift', \Singlephon\Rift\View\Components\Rift::class);

        Blade::directive('rift', function ($expression) {
            return "<?php echo view('rift::components.rift', ['component' => $expression])->render(); ?>";
        });


        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('rift.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/rift'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/rift'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/rift'),
            ], 'lang');*/

            // Registering package commands.
             $this->commands([
                 \Singlephon\Rift\Console\RiftMakeCommand::class,
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'rift');

        // Register the main class to use with the facade
        $this->app->singleton('rift', function () {
            return new Rift;
        });
    }
}
