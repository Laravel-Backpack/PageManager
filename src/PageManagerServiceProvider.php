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
        $router->group(['namespace' => 'Backpack\PageManager\app\Http\Controllers'], function ($router) {
            // Admin Interface Routes
            Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin'], function () {
                // Backpack\PageManager routes
                Route::get('page/create/{template}', 'Admin\PageCrudController@create');
                Route::get('page/{id}/edit/{template}', 'Admin\PageCrudController@edit');

                // This triggered an error before publishing the PageTemplates trait, when calling Route::controller();
                // CRUD::resource('page', 'Admin\PageCrudController');

                // So for PageCrudController all routes are explicitly defined:
                Route::get('page/reorder', 'Admin\PageCrudController@reorder');
                Route::get('page/reorder/{lang}', 'Admin\PageCrudController@reorder');
                Route::post('page/reorder', 'Admin\PageCrudController@saveReorder');
                Route::post('page/reorder/{lang}', 'Admin\PageCrudController@saveReorder');
                Route::get('page/{id}/details', 'Admin\PageCrudController@showDetailsRow');
                Route::get('page/{id}/translate/{lang}', 'Admin\PageCrudController@translateItem');
                Route::resource('page', 'Admin\PageCrudController');
            });
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('pagemanager', function ($app) {
            return new PageManager($app);
        });

        $this->setupRoutes($this->app->router);
    }
}
