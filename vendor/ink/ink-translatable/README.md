# InkTranslatable

Easy translation manipulation of your Eloquent models in Laravel 4.

## Installation

First, you'll need to add the package to the `require` attribute of your `composer.json` file:

```json
{
    "require": {
        "ink/ink-translatable": "dev-master"
    },
}
```

Afterwards, run `composer update` from your command line.

Then, add `'Ink\InkTranslatable\InkTranslatableServiceProvider',` to the list of service providers in `app/config/app.php`
and add `'Translatable' => 'Ink\InkTranslatable\Facades\Translatable'` to the list of class aliases in `app/config/app.php`.

From the command line again, run `php artisan config:publish ink/ink-translatable`.


## Adding locales config

In `app/config/app.php` file add the following content:

```php
    'locales' => array('az', 'ru', 'en'),
```

above the

```php
	'locale' => 'en',
```


## Creating migration

```php
Schema::create('posts', function($table)
{
	$table->increments('id')->unsigned();
	$table->timestamps();
});
Schema::create('posts_translations', function($table)
{
	$table->increments('id')->unsigned();
	$table->integer('post_id')->unsigned();
	$table->string('title');
	$table->string('lang')->index();
	$table->timestamps();
});
```

## Creating RESTful controller & views

`example/app/controllers/PostController.php` file contains controller sample
`example/app/views/post` folder contains sample view files

## Routing

Edit `app/routes.php` file and add following content:

```php
Route::resource('posts', 'PostController');
Route::get('/posts/{id}/delete', 'PostController@destroy');
```

## Updating your Models

Change `Eloquent` to `EloquentTranslatable`

Define a public static property `$translatables` with the translatable fields of the model:

```php
use Ink\InkTranslatable\Models\EloquentTranslatable;

class Post extends EloquentTranslatable
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';
        	
	/**
	 * Translatable model fields.
	 *
	 * @var array
	 */
	public static $translatables = array('title');

}
```

If you wish to have a more customized configuration and override the defaults, use the static property `$translatable` as follows. In this case the property `$translatables` will be omitted:

```php
use Ink\InkTranslatable\Models\EloquentTranslatable;

class Post extends EloquentTranslatable
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';
        	
	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
  	    'translationModel'  => 'PostTranslation',
	    'relationshipField' => 'post_id',
	    'localeField'       => 'lang',
	    'translatables'     => array(
	        'title',
	    )
	);

}
```

Create new model file with name `PostTranslation` for working `posts_translation` table

```php
class PostTranslation extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts_translations';

}
```

That's it ... your model is now "translatable"!

## Basic usage

```phpe

$post = Post::find(1);
echo $post->az->title; // $post->title (for default language)

$post->delete(); // Also deletes all translations

$posts = Post::with('translations')->get(); // Eager loading
// $posts = Post::all(); // if you want to get different language details ($post->az->title) turn off eager loading beacuse eager loading will be ignored
foreach ($posts as $post) {
	echo $post->title; // $post->az->title
}

```

## Bugs and Suggestions

Please use Github for bugs, comments, suggestions. Pull requests are preferred!


## Copyright and License

InkTranslatable was written by Orkhan Maharramli and released under the MIT License. See the LICENSE file for details.

Copyright 2013 Orkhan Maharramli
