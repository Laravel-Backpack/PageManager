<?php

namespace Backpack\PageManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Route;

class PageManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var string
     */
    protected $adminControllerClass = 'Backpack\PageManager\App\Http\Controllers\Admin\PageCrudController';

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
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // Admin Interface Routes
        Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('backpack.base.route_prefix', 'admin')], function () {

            $controller = $this->adminControllerClass;

            // Backpack\PageManager routes
            Route::get('page/create/{template}', $controller . '@create');
            Route::get('page/{id}/edit/{template}', $controller . '@edit');

            // This triggered an error before publishing the PageTemplates trait, when calling Route::controller();
            // CRUD::resource('page', $controller . '');

            // So for PageCrudController all routes are explicitly defined:
            Route::get('page/reorder', $controller . '@reorder');
            Route::get('page/reorder/{lang}', $controller . '@reorder');
            Route::post('page/reorder', $controller . '@saveReorder');
            Route::post('page/reorder/{lang}', $controller . '@saveReorder');
            Route::get('page/{id}/details', $controller . '@showDetailsRow');
            Route::get('page/{id}/translate/{lang}', $controller . '@translateItem');
            Route::resource('page', $controller);
        });
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
