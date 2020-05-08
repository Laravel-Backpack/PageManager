# Changelog

All Notable changes to `BackPack\PageManager` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

------
IMPORTANT
------

We no longer use this file to track changes. Please see our repo's "Releases" tab, on Github:
https://github.com/Laravel-Backpack/PageManager/releases

------

## 3.0.0 - 2020-05-06

### Added
- support for Backpack 4.1;

### Removed
- support for Backpack 4.0;
- laravel/helpers dependency;


------


## 2.0.7 - 2020-03-05

### Fixed
- upgraded PHPUnit to 9 or 7;


## 2.0.6 - 2020-03-05

### Added
- support for Laravel 7;


## 2.0.5 - 2020-01-14

### Added
- merged #101 - added Indonesian language file;


## 2.0.4 - 2019-12-19

### Added
- Farsi (Persian) language file;


## 2.0.3 - 2019-12-17

### Fixed
- fixed #98 - allow installation on Backpack 4.0 on Laravel 5.8;


## 2.0.2 - 2019-11-17

### Added
- Russian language translation;


## 2.0.1 - 2019-10-04

### Added
- extras is cast as array on the Page model;


## 2.0.0 - 2019-09-24

### Added
- Backpack v4 support;

### Removed
- Backpack v3 support;

------


## 1.1.29 - 2019-09-04

### Added
- Laravel 6 support;


## 1.1.28 - 2019-02-27

### Fixed
- #79, merged #81 - changing template on Create page;

## 1.1.27 - 2018-12-06

### Fixed
- #75 - using old version of select_page_template field;


## 1.1.26 - 2018-11-16

### Fixed
- #73 - hotfix;

## 1.1.25 - 2018-11-16

### Fixed
- #73 - converting template method name to a readable name stripped characters in some instances;

## 1.1.24 - 2018-10-16

### Added
- PT translation;
- merged #70 - using custom Backpack guard as defined by ```backpack_auth()```;
- put PageManager panel behind standard Backpack middleware (defined in Base config file);

## 1.1.23 - 2018-03-13

### Added
- FR, DE and NL translations;


## 1.1.22 - 2017-11-02

### Added
- search route for CRUD 3.3 upgrade;


## 1.1.21 - 2017-08-30

### Added
- package autodiscovery for Laravel 5.5;


## 1.1.20 - 2017-08-11

### Added
- Danish (da_DK) language files, thanks to [Frederik Rabøl](https://github.com/Xayer);


## 1.1.19 - 2017-07-18

### Added
- language file support and EN and IT language files, thanks to [Federico Liva](https://github.com/fede91it);


## 1.1.18 - 2017-07-06

### Added
- overwritable routes file;

### Fixed
- versioning accidentaly jumped to 1.1.17;

## 1.1.10 - 2017-07-05

### Fixed
- prettier error message when template has been deleted;
- filterable getTemplates() method, using reflection;


## 1.1.9 - 2017-04-18

### Fixed
- longText extras column;


## 1.1.8 - 2017-04-11

### Fixed
- lowercase app namespace everywhere;


## 1.1.7 - 2017-04-06

### Fixed
- class does not exist issue, because of lowercase app in configured namespace;

## 1.1.6 - 2017-04-05

### Fixed
- moved pagemanager.php config file to the backpack folder;


## 1.1.5 - 2017-04-05

### Fixed
- creating pages with no slugs;


## 1.1.4 - 2017-04-05

### Added
- ability to easily extend the Controller or Model (thanks to [Carl Olsen](https://github.com/unstoppablecarl));


## 1.1.3 - 2016-10-30

### Fixed
- Routes now follow the route_prefix set in config, with an "admin" default;


## 1.1.2 - 2016-10-12

### Fixed
- Routes now follow the route_prefix set in config;


## 1.1.1 - 2016-09-12

### Added
- Page model uses eloquent-sluggable trait for fetching items by slug.
- Example front-end code.


## 1.1.0 - 2016-08-31

### Added
- Eloquent-sluggable version 4.


## 1.0.9 - 2016-07-31

### Fixed
- Working bogus unit tests.


## 1.0.8 - 2016-07-31

### Added
- Bogus unit tests. At least we'be able to use travis-ci for requirements errors, until full unit tests are done.


## 1.0.7 - 2016-07-24

### Fixed
- fixed select_page_template field;
- changed template and page_name fields to col-md-6;
- changed Preview column with Open button;


## 1.0.6 - 2016-07-23

### Added
- Required CRUD 3.0


## 1.0.5 - 2016-06-03

### Fixed
- Additional methods on PageCrudController are now public instead of private, so PageCrudController can more easily be extended.


## 1.0.4 - 2016-06-02

### Fixed
- Using the Admin middleware instead of Auth, as of Backpack\Base v0.6.0;
- Moved routes definition to PageManagerServiceProvider;


## 1.0.3 - 2016-06-01

### Fixed
- Slug wasn't generated from title, but name.


## 1.0.2 - 2016-05-25

### Fixed
- Added Backpack\CRUD requirement in composer.json


## 1.0.1 - 2016-05-25

### Fixed
- composer.json


## 1.0.0 - 2016-05-25

### Added
- Basic functionality.
