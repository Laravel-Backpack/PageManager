# BackPack\PageManager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An interface to let your admins add and edit presentation pages to your Laravel 5 website, by defining page templates with any number of content areas and any number of content types. Uses [Laravel Backpack](https://github.com/laravel-backpack).

> ### Security updates and breaking changes
> Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.


## Install

1) In your terminal

``` bash
$ composer require backpack/pagemanager
```

2) For Laravel apps <5.5, add the service providers to your config/app.php file:

```
Cviebrock\EloquentSluggable\ServiceProvider::class, 
Backpack\PageManager\PageManagerServiceProvider::class,
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

```html
<li><a href="{{ url(config('backpack.base.route_prefix').'/page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>
```


## Usage

1. Go to **yourapp/admin/page** and see how it works.
2. Define your own templates in app/PageTemplates.php using the Backpack\CRUD API.

## Example front-end

No front-end is provided (Backpack only takes care of the admin panel), but for most projects this front-end code will be all you need:

(1) Create a catch-all route at the end of your routes file:
```php
/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^((?!admin).)*$', 'subs' => '.*']);
```

(2) Create ```app\Http\Controllers\PageController.php``` that actually shows the page.
```php
<?php

namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index($slug)
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

If you discover any security related issues, please email hello@tabacitu.ro instead of using the issue tracker.

## Credits

- [Cristian Tabacitu][link-author]
- [All Contributors][link-contributors]

## License

Backpack is free for non-commercial use and 39 EUR/project for commercial use. Please see [License File](LICENSE.md) and [backpackforlaravel.com](https://backpackforlaravel.com/#pricing) for more information.

[ico-version]: https://img.shields.io/packagist/v/backpack/PageManager.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/laravel-backpack/PageManager/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/laravel-backpack/PageManager.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/laravel-backpack/PageManager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/laravel-backpack/PageManager.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/laravel-backpack/PageManager
[link-travis]: https://travis-ci.org/laravel-backpack/PageManager
[link-scrutinizer]: https://scrutinizer-ci.com/g/laravel-backpack/PageManager/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/laravel-backpack/PageManager
[link-downloads]: https://packagist.org/packages/laravel-backpack/PageManager
[link-author]: https://github.com/tabacitu
[link-contributors]: ../../contributors
