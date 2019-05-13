<?php

return [
    // Change this class if you wish to extend PageCrudController
    'admin_controller_class'        => 'Backpack\PageManager\app\Http\Controllers\Admin\PageCrudController',

    // Change this class if you wish to extend the Page model
    // remember to change 'unique_page_model_class' if you want to use the same model
    'page_model_class'              => 'Backpack\PageManager\app\Models\Page',

    // Change this class if you wish to extend UniquePageCrudController
    'unique_admin_controller_class' => 'Backpack\PageManager\app\Http\Controllers\Admin\UniquePageCrudController',

    // Change this class if you wish to extend the Page model for unique pages
    'unique_page_model_class'       => 'Backpack\PageManager\app\Models\Page',

    // Set to true if you want to use revisions on unique pages
    // This requires you to extend the class you use for unique pages
    // For setup details please check the backpack documentation on revisions
    'unique_page_revisions'         => false,
];
