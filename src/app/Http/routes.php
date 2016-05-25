<?php

// Admin Interface Routes
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin'], function()
{
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