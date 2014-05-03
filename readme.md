# TypiCMS [![Build Status](https://travis-ci.org/sdebacker/TypiCMS.svg?branch=master)](https://travis-ci.org/sdebacker/TypiCMS)

TypiCMS is a multilingual content management system build with Laravel 4.1.  
Bower and gulp are used for assets management and user interface is build with Bootstrap 3 with Less.

**Demo**

* [Back-end](http://typicms.samsfactory.com/admin) (login: ``` admin@example.com ```, password: ``` admin ```)
* [Front-end](http://typicms.samsfactory.com)

![TypiCMS screenshot](http://typicms.samsfactory.com/uploads/pages/TypiCMS-screenshot-o.png)

## Table of contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Modules](#modules)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [Testing](#testing)
- [Licence](#licence)

## Features

### URLs

This kind of urls are managed by the CMS :

**Modules:**

* /en/events/slug-in-english
* /fr/evenements/slug-en-francais

**Pages:**

* /en/parent-pages-slug-en/subpage-slug-en/page-slug-en
* /fr/parent-pages-slug-fr/subpage-slug-fr/page-slug-fr

### Patterns

- Repositories
- Cache decorator
- Form and validation services
- Presenters

### Assets

- Gulp
- Bower
- Bootstrap 3

## Requirements

- PHP >= 5.4.0
- MCrypt PHP Extension
- Memcached or APC

## Installation

1. Download TypiCMS ``` git clone git://github.com/sdebacker/TypiCMS.git mywebsite```
2. Enter newly created folder ``` cd mywebsite ```
3. Install dependencies with [Composer](https://getcomposer.org/doc/00-intro.md) : ``` Composer install ```
4. Fill in your MySQL credentials in env.local.php
5. Rename env.local.php to .env.local.php : ``` mv env.local.php .env.local.php ```
6. Create a new database with the name filled in .env.local.php
7. Migrate and seed Database : ``` php artisan migrate --seed ```
8. Set permissions ``` chmod -R 777 app/storage ``` and ``` chmod -R 777 public/uploads ```
9. Go to http://mywebsite.local/admin and log in with admin@example.com as email and admin as password.

## Configuration

1. Set available locale and default locale in app/config/app.php
2. Set a new encryption key manually or with ``` php artisan key:generate ```
3. Change cache prefix in app/config/cache.php
4. Cache driver is set to memcached, you can change it to apc in app/config/cache.php

## Modules

### Pages

Pages are nestable with drag and drop, on drop, uris are generated and saved in database. A page has routes for each translation.

### Menus

Each menu have nestable entries. One entry can be linked to a module, page, URI or URL.

### Projects

Projects have categories, projects urls follows this pattern : /en/projects/category-slug/project-slug

### Categories

Categories has many projects.

### Tags

Tags are linked to projects and use [Select2](http://ivaynberg.github.io/select2/) js plugin.  
It has many to many polymorphic relations so it could easily be linked to other modules.

### Events

Events have starting and ending dates

### News

Simple news module

### Contacts

Frontend contact form and admin side records management

### Files

Files module allows you to upload multiple files linked to a resource. It uses [DropzoneJS](http://www.dropzonejs.com).  
Thumbnails are generated on the fly with [Croppa](https://github.com/BKWLD/croppa).

### Users and groups

[Sentry 2](https://cartalyst.com/manual/sentry) is used to manage users, groups and permissions.  
Users registration can be enable through the settings panel (/admin/settings).

### Translations

Translations can be store in database through the admin panel (/admin/translations).  
Each cell of the translation table is editable in place.

You can call DB translation everywhere with ``` Lang::get('db.Key') ```, ``` trans('db.Key') ``` or ``` @lang('db.Key') ```.

### Settings

Change website title, and other options trough the settings panel. Settings are saved in database.

## Roadmap

* Improve user interface
* Make modules as packages
* Build more tests

## Contributing

TypiCMS needs many improvements, some options are not yet implemented and some code need to be simplified and moved in separate classes.  
TypiCMS follow [PSR-2](http://www.php-fig.org/psr/psr-2/) standard.

## Testing

Some admin controllers are actually tested, more tests needed.

## License

TypiCMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
