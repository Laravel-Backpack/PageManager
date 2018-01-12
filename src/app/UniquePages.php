<?php

namespace App;

trait UniquePages
{
    /*
    |--------------------------------------------------------------------------
    | Unique pages for Backpack\PageManager
    |--------------------------------------------------------------------------
    |
    | Each unique page has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will generate the page on first edit
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template (hidden and fix)
    | - page name (only seen by admins) (hidden and fix)
    | - page title
    | - page slug (hidden and fix, slug of method name)
    */

    private function about_us()
    {
        $this->crud->addField([
            'name' => 'content',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'wysiwyg',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
        ]);
    }

    private function some_thing()
    {
        $this->crud->addField([
            'name' => 'content',
            'label' => trans('backpack::pagemanager.content'),
            'type' => 'simplemde',
            'placeholder' => trans('backpack::pagemanager.content_placeholder'),
        ]);
    }
}
