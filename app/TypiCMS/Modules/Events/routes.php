<?php
Route::bind('events', function ($value) {
    return TypiCMS\Modules\Events\Models\Event::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(
        array(
            'before'    => 'visitor.publicAccess',
            'namespace' => 'TypiCMS\Modules\Events\Controllers',
        ),
        function () {
            $routes = app('TypiCMS.routes');
            foreach (Config::get('app.locales') as $lang) {
                if (isset($routes['events'][$lang])) {
                    $uri = $routes['events'][$lang];
                } else {
                    $uri = 'events';
                    if (Config::get('app.fallback_locale') != $lang || Config::get('app.main_locale_in_url')) {
                        $uri = $lang . '/' . $uri;
                    }
                }
                Route::get(
                    $uri,
                    array('as' => $lang.'.events', 'uses' => 'PublicController@index')
                );
                Route::get(
                    $uri.'/{slug}',
                    array('as' => $lang.'.events.slug', 'uses' => 'PublicController@show')
                );
                Route::get(
                    $uri.'/{slug}/ics',
                    array('as' => $lang.'.events.slug.ics', 'uses' => 'PublicController@ics')
                );
            }
        }
    );
}

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Events\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('events', 'AdminController');
    }
);

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'events',
        'TypiCMS\Modules\Events\Controllers\ApiController'
    );
});
