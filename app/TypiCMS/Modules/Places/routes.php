<?php
Route::bind('places', function ($value) {
    return TypiCMS\Modules\Places\Models\Place::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(
        array(
            'before'    => 'visitor.publicAccess',
            'namespace' => 'TypiCMS\Modules\Places\Controllers',
        ),
        function () {
            $routes = app('TypiCMS.routes');
            foreach (Config::get('app.locales') as $lang) {
                if (isset($routes['places'][$lang])) {
                    $uri = $routes['places'][$lang];
                } else {
                    $uri = 'places';
                    if (Config::get('app.fallback_locale') != $lang || Config::get('app.main_locale_in_url')) {
                        $uri = $lang . '/' . $uri;
                    }
                }
                Route::get($uri, array('as' => $lang.'.places', 'uses' => 'PublicController@index'));
                Route::get($uri.'/{slug}', array('as' => $lang.'.places.slug', 'uses' => 'PublicController@show'));
            }
        }
    );
}

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Places\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('places', 'AdminController');
    }
);

Route::group(array('prefix'=>'api'), function() {
    Route::resource(
        'places',
        'TypiCMS\Modules\Places\Controllers\ApiController'
    );
});
