# BackPack\PageManager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


An interface to let your admins add and edit presentation pages to your Laravel 6, 7 or 8 website, by defining page templates with any number of content areas and any number of content types. Uses [Laravel Backpack](https://github.com/laravel-backpack).

![Backpack PageManager edit page](https://user-images.githubusercontent.com/1032474/106446854-6dc73100-6489-11eb-9e4c-b21273cef23e.png "PageManager edit page")


> ### Security updates and breaking changes
> Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.


## Install

1) Add a file to define your page templates in ```app/PageTemplates.php```:
```php
<?php

namespace App;

trait PageTemplates
{
    /*
    |--------------------------------------------------------------------------
    | Page Templates for Backpack\PageManager
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    | - page name (only seen by admins)
    | - page title
    | - page slug
    */

    private function services()
    {
        $this->crud->addField([   // CustomHTML
                        'name' => 'metas_separator',
                        'type' => 'custom_html',
                        'value' => '<br><h2>'.trans('backpack::pagemanager.metas').'</h2><hr>',
                    ]);
        $this->crud->addField([
                        'name' => 'meta_title',
                        'label' => trans('backpack::pagemanager.meta_title'),
                        'fake' => true,
                        'store_in' => 'extras',
                    ]);
        $this->crud->addField([
                        'name' => 'meta_description',
                        'label' => trans('backpack::pagemanager.meta_description'),
                        'fake' => true,
                        'store_in' => 'extras',
                    ]);
        $this->crud->addField([
                        'name' => 'meta_keywords',
                        'type' => 'textarea',
                        'label' => trans('backpack::pagemanager.meta_keywords'),
                        'fake' => true,
                        'store_in' => 'extras',
                    ]);
        $this->crud->addField([   // CustomHTML
                        'name' => 'content_separator',
                        'type' => 'custom_html',
                        'value' => '<br><h2>'.trans('backpack::pagemanager.content').'</h2><hr>',
                    ]);
        $this->crud->addField([
                        'name' => 'content',
                        'label' => trans('backpack::pagemanager.content'),
                        'type' => 'wysiwyg',
                        'placeholder' => trans('backpack::pagemanager.content_placeholder'),
                    ]);
    }

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
```

2) In your terminal

``` bash
composer require backpack/pagemanager
```

3) Publish the views, migrations and the PageTemplates trait:

```
php artisan vendor:publish --provider="Backpack\PageManager\PageManagerServiceProvider"
```

4) Run the migration to have the database table we need:

```
php artisan migrate
```

5) [optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```
php artisan backpack:add-sidebar-content "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class='nav-icon la la-file-o'></i> <span>Pages</span></a></li>"
```


## Usage

1. Go to **yourapp/admin/page** and see how it works.
2. Define your own templates in app/PageTemplates.php using the Backpack\CRUD API.

## Example front-end

No front-end is provided (Backpack only takes care of the admin panel), but for most projects this front-end code will be all you need:

(1) Create a catch-all route at the end of your routes file:
```php
/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])
    ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
```

(2) Create ```app\Http\Controllers\PageController.php``` that actually shows the page.
```php
<?php

namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index($slug, $subs = null)
    {
        $page = Page::findBySlug($slug);

        if (!$page)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = $page->title;
        $this->data['page'] = $page->withFakes();

        return view('pages.'.$page->template, $this->data);
    }
}
```

(3) Create the views for those templates (how those pages actually look - the HTML CSS JS) and place them in your ```resources/views/pages/``` directory. Inside those blade files, you can use the ```$page``` variable. That's where all the page content is stored. For more complicated pages, you can also use [fake fields](https://laravel-backpack.readme.io/docs/crud#section-extras-fake-fields-stored-as-json-in-the-database-) in your page templates. You'll also find those attributes in the ```$page``` variable.

Note: if you find yourself in need of sending extra data to a view you load on multiple pages, you should consider [using a view composer](https://laravel.com/docs/5.3/views#view-composers);

## Extend

If you need to make any modifications to the controller, model or request, you should:
- make sure ```config/backpack/pagemanager.php``` is published; if not, publish it using ```php artisan vendor:publish --provider="Backpack\PageManager\PageManagerServiceProvider"```;
- create a new controller/model that extends the one in the package;
- enter controller or model in the pagemanager.php config file, and that's the one that the CRUD will be using;

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Overwriting Functionality

If you need to modify how this works in a project: 
- create a ```routes/backpack/pagemanager.php``` file; the package will see that, and load _your_ routes file, instead of the one in the package; 
- create controllers/models that extend the ones in the package, and use those in your new routes file;
- modify anything you'd like in the new controllers/models;

## Security

If you discover any security related issues, please email hello@backpackforlaravel.com instead of using the issue tracker.

## Credits

- [Cristian Tabacitu][link-author]
- [All Contributors][link-contributors]

## License

Backpack is free for non-commercial use and 69 EUR/project for commercial use. Please see [License File](LICENSE.md) and [backpackforlaravel.com](https://backpackforlaravel.com/#pricing) for more information.

## Hire us

We've spend more than 10.000 hours creating, polishing and maintaining administration panels on Laravel. We've developed e-Commerce, e-Learning, ERPs, social networks, payment gateways and much more. We've worked on admin panels _so much_, that we've created one of the most popular software in its niche - just from making public what was repetitive in our projects.

If you are looking for a developer/team to help you build an admin panel on Laravel, look no further. You'll have a difficult time finding someone with more experience & enthusiasm for this. This is _what we do_. [Contact us - let's see if we can work together](https://backpackforlaravel.com/need-freelancer-or-development-team).

[ico-version]: https://img.shields.io/packagist/v/backpack/PageManager.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/laravel-backpack/PageManager/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/laravel-backpack/PageManager.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/laravel-backpack/PageManager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/backpack/pagemanager.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/backpack/pagemanager
[link-travis]: https://travis-ci.org/laravel-backpack/PageManager
[link-scrutinizer]: https://scrutinizer-ci.com/g/laravel-backpack/PageManager/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/laravel-backpack/PageManager
[link-downloads]: https://packagist.org/packages/backpack/pagemanager
[link-author]: https://github.com/tabacitu
[link-contributors]: ../../contributors
