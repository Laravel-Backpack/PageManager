<?php

namespace App;

trait UniquePages
{
    /*
    |--------------------------------------------------------------------------
    | Unique pages for Backpack\PageManager
    |--------------------------------------------------------------------------
    |
    | Each unique page has its own method that defines what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will generate the page on first edit.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template (hidden field and not editable)
    | - page name (only seen by admins)
    | - page title
    | - page slug (hidden and not editable, generated as slug of method name)
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
}
