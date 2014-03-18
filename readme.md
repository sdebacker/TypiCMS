# TypiCMS

TypiCMS is a starting point for a multilingual content management system build with Laravel.
Bower and gulp are used for assets management and user interface is build with Bootstrap 3 with Less.

This kind of urls are managed by the CMS :

Modules:

* /fr/evenements/slug-en-francais
* /en/events/slug-in-english

Pages:

* /fr/parent-pages-slug-fr/subpage-slug-fr/page-slug-fr
* /en/parent-pages-slug-en/subpage-slug-en/page-slug-en

## Table of contents

 - [Requirements](#requirements)
 - [Installation](#installation)
 - [Modules](#modules)
 - [Contributing](#contributing)
 - [Testing](#testing)
 - [Licence](#licence)

## Requirements

PHP >= 5.4.0 is required with MCrypt PHP Extension

## Installation

* Download archive ``` git clone git://github.com/sdebacker/TypiCMS.git ```
* ``` cd TypiCMS ```
* Install dependencies with [Composer](https://getcomposer.org/doc/00-intro.md) : ``` Composer install ```
* Fill in your MySQL credentials in env.local.php
* Rename env.local.php to .env.local.php : ``` mv env.local.php .env.local.php ```
* Create a new database with the name filled in .env.local.php
* Migrate and seed Database : ``` php artisan migrate --seed ```
* ``` chmod -R 777 app/storage ``` and ``` chmod -R 777 public/uploads ```
* Go to http://localhost/admin and log in with admin@example.com as email and admin as password.

## Modules

### Pages

Pages are nestable by drag and drop and uris autocreated and saved in database. A page has routes for each translation.

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

### Files

Files module allows you to upload multiple files linked to a resource. It uses [DropzoneJS](http://www.dropzonejs.com).

Thumbnails are generated on the fly with [Croppa](https://github.com/BKWLD/croppa).

### Users and groups

[Sentry 2](https://cartalyst.com/manual/sentry) is used to manage users, groups and permissions.
Users registration can be enable through the settings panel (/admin/settings).

### Settings

Change website title, and other options trough the settings panel. Settings are saved in database.

## Contributing

TypiCMS needs many improvements, some options are not yet implemented and some code need to be simplified and moved in separate classes.
TypiCMS follow [PSR-2](http://www.php-fig.org/psr/psr-2/) standards.

## Testing

Some admin controllers are actually tested, more tests needed.

## License

TypiCMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
