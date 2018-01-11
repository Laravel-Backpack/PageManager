<?php

return [
    // Change this class if you wish to extend PageCrudController
    'admin_controller_class' => 'Backpack\PageManager\app\Http\Controllers\Admin\PageCrudController',

    // Change this class if you wish to extend the Page model
    'page_model_class'       => 'Backpack\PageManager\app\Models\Page',

    // Change this class if you wish to extend UniquePageCrudController
    'unique_admin_controller_class' => 'Backpack\PageManager\app\Http\Controllers\Admin\UniquePageCrudController',

    // Change this class if you wish to extend the Page model for unique pages
    'unique_page_model_class'       => 'Backpack\PageManager\app\Models\Page',
];
