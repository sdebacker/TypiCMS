## Basset for Laravel 4

[![Build Status](https://secure.travis-ci.org/jasonlewis/basset.png)](http://travis-ci.org/jasonlewis/basset)

Basset is a better asset management package for the Laravel framework. Basset shares the same philosophy as Laravel. Development should be an enjoyable and fulfilling experience. When it comes to managing your assets it can become quite complex and a pain in the backside. These days developers are able to use a range of pre-processors such as Sass, Less, and CoffeeScript. Basset is able to handle the processing of these assets instead of relying on a number of individual tools.

### Installation

- [Basset on Packagist](https://packagist.org/packages/jasonlewis/basset)
- [Basset on GitHub](https://github.com/jasonlewis/basset)

To get the latest version of Basset simply require it in your `composer.json` file.

~~~
"jasonlewis/basset": "dev-master"
~~~

You'll then need to run `composer install` to download it and have the autoloader updated.

> Note that once Basset has a stable version tagged you should use a tagged release instead of the master branch.

Once Basset is installed you need to register the service provider with the application. Open up `app/config/app.php` and find the `providers` key.

~~~
'providers' => array(
    
    'Basset\BassetServiceProvider'

)
~~~

Basset also ships with a facade which provides the static syntax for creating collections. You can register the facade in the `aliases` key of your `app/config/app.php` file.

~~~
'aliases' => array(

    'Basset' => 'Basset\Facade'

)
~~~

### Documentation

[View the official documentation](http://jasonlewis.me/code/basset/4.0).

### Changes

#### v4.0.0 Beta 3

- Split the collections and aliases into their own configuration files.
- Filter method chaining with syntactical sugar by prefixing with `and`, e.g., `andWhenProductionBuild()`.

#### v4.0.0 Beta 2

- Added logging when assets, directories, and filters are not found or fail to load.
- Allow logging to be enabled or disabled via configuration.
- Warn users when cURL is being used to detect an assets group.
- Allow an array of filters to be applied to an asset.
- Added `whenProductionBuild` and `whenDevelopmentBuild` as filter requirements.
- `CssMin` and `JsMin` are only applied on a production build and not on the production environment.
- Added `raw` method as an alias to `exclude`.
- Entire directory or collection can be set as raw so original path is used instead of assets being built.
- Development builds only happen for a collection that is used on the loaded request.
- Added `rawOnEnvironment` to serve the asset raw on a given environment or environments.


#### v4.0.0 Beta 1

- Collections are displayed with `basset_javascripts()` and `basset_stylesheets()`.
- Simplified the asset finding process.
- Can no longer prefix paths with `path:` for an absolute path, use a relative path from public directory instead.
- Requirements can be applied to filters to prevent application if certain conditions are not met.
- Filters can find any missing constructor arguments such as the path to Node, Ruby, etc.
- Default `application` collection is bundled.
- `basset:compile` command is now `basset:build`.
- Old collection builds are cleaned automatically but can be cleaned manually with `basset --tidy-up`.
- Packages can be registered with `Basset::package()` and assets can be added using the familiar namespace syntax found throughout Laravel.
- `Csso` support with `CssoFilter`.
- Fixed issues with `UriRewriteFilter`.
- Development collections are pre-built before every page load.
- Build and serve pre-compressed collections.
- Use custom format when displaying collections.
- Added in Blade view helpers: `@javascripts`, `@stylesheets`, and `@assets`.
- Assets maintain the order that they were added.