<?php

/*
|--------------------------------------------------------------------------
| Backpack\PageManager Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\PageManager package.
|
*/

Route::group([
        'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
        'prefix' => config('backpack.base.route_prefix', 'admin'),
    ], function () {
        $controller = config('backpack.pagemanager.admin_controller_class', 'Backpack\PageManager\app\Http\Controllers\Admin\PageCrudController');

        // Backpack\PageManager routes
        Route::get('page/create/{template}', $controller.'@create');
        Route::get('page/{id}/edit/{template}', $controller.'@edit');

        // This triggered an error before publishing the PageTemplates trait, when calling Route::controller();
        // CRUD::resource('page', $controller . '');

        // So for PageCrudController all routes are explicitly defined:
        Route::get('page/reorder', $controller.'@reorder');
        Route::get('page/reorder/{lang}', $controller.'@reorder');
        Route::post('page/reorder', $controller.'@saveReorder');
        Route::post('page/reorder/{lang}', $controller.'@saveReorder');
        Route::get('page/{id}/details', $controller.'@showDetailsRow');
        Route::get('page/{id}/translate/{lang}', $controller.'@translateItem');

        Route::post('page/search', [
            'as' => 'crud.page.search',
            'uses' => $controller.'@search',
        ]);

        Route::resource('page', $controller);

        // Backpack\PageManager routes for unique pages
        $uniqueController = config('backpack.pagemanager.unique_admin_controller_class', 'Backpack\PageManager\app\Http\Controllers\Admin\UniquePageCrudController');

        Route::get('unique/{slug}', $uniqueController.'@uniqueEdit');
        Route::put('unique/{slug}/{id}', $uniqueController.'@update');

        if (config('backpack.pagemanager.unique_page_revisions')) {
            Route::get('unique/{slug}/{id}/revisions', [
                'as' => 'crud.unique.listRevisions',
                'uses' => $uniqueController.'@uniqueRevisions',
            ]);
            Route::post('unique/{slug}/{id}/revisions/{revisionId}/restore', [
                'as' => 'crud.unique.restoreRevision',
                'uses' => $uniqueController.'@restoreUniqueRevision',
            ]);
        }
    });
