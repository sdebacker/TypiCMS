<?php
Route::model('places', 'TypiCMS\Modules\Places\Models\Place');

if (! App::runningInConsole()) {
    Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
        $routes = app('TypiCMS.routes');
        foreach (Config::get('app.locales') as $lang) {
            $uri = (array_key_exists('places', $routes)) ? $routes['places'][$lang] : $lang.'/places' ;
            Route::get(
                $uri,
                array(
                    'as' => $lang.'.places',
                    'uses' => 'TypiCMS\Modules\Places\Controllers\PublicController@index'
                )
            );
            Route::get(
                $uri.'/{slug}',
                array(
                    'as' => $lang.'.places.slug',
                    'uses' => 'TypiCMS\Modules\Places\Controllers\PublicController@show'
                )
            );
        }
    });
}

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource(
        'places',
        'TypiCMS\Modules\Places\Controllers\AdminController'
    );
    Route::post(
        'places/sort',
        array(
            'as' => 'admin.places.sort',
            'uses' => 'TypiCMS\Modules\Places\Controllers\AdminController@sort'
        )
    );
});
