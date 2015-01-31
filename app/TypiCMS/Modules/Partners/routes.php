<?php
Route::bind('partners', function ($value) {
    return TypiCMS\Modules\Partners\Models\Partner::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(
        array(
            'before'    => 'visitor.publicAccess',
            'namespace' => 'TypiCMS\Modules\Partners\Controllers',
        ),
        function () {
            $routes = app('TypiCMS.routes');
            foreach (Config::get('app.locales') as $lang) {
                if (isset($routes['partners'][$lang])) {
                    $uri = $routes['partners'][$lang];
                } else {
                    $uri = 'partners';
                    if (Config::get('app.fallback_locale') != $lang || Config::get('app.main_locale_in_url')) {
                        $uri = $lang . '/' . $uri;
                    }
                }
                Route::get($uri, array('as' => $lang.'.partners', 'uses' => 'PublicController@index'));
                Route::get($uri.'/{slug}', array('as' => $lang.'.partners.slug', 'uses' => 'PublicController@show'));
            }
        }
    );
}

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Partners\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('partners', 'AdminController');
        Route::post('partners/sort', array('as' => 'admin.partners.sort', 'uses' => 'AdminController@sort'));
    }
);

Route::group(array('prefix'=>'api'), function() {
    Route::resource(
        'partners',
        'TypiCMS\Modules\Partners\Controllers\ApiController'
    );
});
