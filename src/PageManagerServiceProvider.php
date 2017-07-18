<?php

namespace Backpack\PageManager;

use Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class PageManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/backpack/pagemanager.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // publish views
        $this->publishes([__DIR__.'/resources/views' => base_path('resources/views')], 'views');
        // publish PageTemplates trait
        $this->publishes([__DIR__.'/app/PageTemplates.php' => app_path('PageTemplates.php')], 'trait');
        // publish migrations
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');
        // public config
        $this->publishes([__DIR__.'/config/pagemanager.php' => config_path('backpack/pagemanager.php')]);
        // public languages
        $this->publishes([__DIR__.'/resources/lang' => resource_path('lang/vendor/backpack')], 'lang');

        $this->mergeConfigFrom(__DIR__.'/config/pagemanager.php', 'backpack.pagemanager');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupRoutes($this->app->router);
    }
}
