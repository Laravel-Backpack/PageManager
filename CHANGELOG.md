# Changelog

All Notable changes to `BackPack\PageManager` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## NEXT - YYYY-MM-DD

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing


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
