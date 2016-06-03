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