<?php

namespace App;

trait UniquePages
{
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