The basic idea is simple: make form creation simpler.

[View a quick visual
demonstration.](https://dl.dropboxusercontent.com/u/774859/GitHub-Repos/formfield-sample.mp4)

I'm tired of creating form fields, like this:

```html
<div class="form-group">
    {{  Form::label('username', 'Username:' ) }}
    {{ Form::text('username', null, ['class' => 'control-group']) }}
</div>
```

Instead, with this `FormField` class, you can simply do:

```php
{{ FormField::username() }}
```

That will then produce the necessary (Bootstrap-friendly, by default) HTML. It uses dynamic methods to
simplify the process a bit.

While it will do its best to figure out what kind of input you want, you
can override it.

```php
{{ FormField::yourBio(['type' => 'textarea']) }}
```

This will produce:

```html
<div class='form-group'>
    <label for="yourBio">Your Bio: </label>
    <textarea class="form-control" type="textarea" name="yourBio" cols="50" rows="10" id="yourBio"></textarea>
</div>
```

So, yeah, it's just a helper class. If your forms require a huge amount
of customization, this probably won't work for you. But for simple
forms, it'll do the trick nicely!

(It also makes Laracasts demos way easier to setup. :)

## Usage

To try this out:

Begin by installing the package through Composer.

```js
require: {
    "way/form": "dev-master"
}
```

Next, add the service provider to `app/config/app.php`.

```php
'providers' => [
    // ..
    'Way\Form\FormServiceProvider'
]
```

That's it! You're all set to go. Try it out in a view:

```php
{{ FormField::username() }}
{{ FormField::email() }}
{{ FormField::custom(['type' => 'textarea']) }}
{{ FormField::address(['label' => 'Your Address']) }}
```

That will produce the following. Though it's Twitter Bootstrap friendly
by default, you can of course customize the class names as you wish.

![output](https://dl.dropboxusercontent.com/u/774859/GitHub-Repos/formfield-ss.png)

If you want to override the defaults, you can publish the config, like
so:

    php artisan config:publish way/form

Now, access `app/config/packages/way/form/config.php` to customize.
Here's what it lists by default:

```php
return [

    /*
     * What should each form element be
     * wrapped within?
    */
    'wrapper' => 'div',

    /*
     * What class should the wrapper
     * element receive?
    */
    'wrapperClass' => 'form-group',

    /**
     * Should form inputs receive a class name?
     */
    'inputClass' => 'form-control',

    /**
     * Frequent input names can map
     * to their respective input types.
     *
     * This way, you may do FormField::description()
     * and it'll know to automatically set it as a textarea.
     * Otherwise, do FormField::thing(['type' => 'textarea'])
     *
     */
    'commonInputsLookup'  => [
        'email' => 'email',
        'emailAddress' => 'email',

        'description' => 'textarea',
        'bio' => 'textarea',
        'body' => 'textarea',

        'password' => 'password',
        'password_confirmation' => 'password'
    ]
];
```
