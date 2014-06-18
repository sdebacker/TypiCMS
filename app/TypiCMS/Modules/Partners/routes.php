<?php
Route::model('partners', 'TypiCMS\Modules\Partners\Models\Partner');

if (! App::runningInConsole()) {
    Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
        $routes = app('TypiCMS.routes');
        foreach (Config::get('app.locales') as $lang) {
            if (isset($routes['partners'][$lang])) {
                $uri = $routes['partners'][$lang];
            } else {
                $uri = 'partners';
                if (Config::get('app.locale_in_url')) {
                    $uri = $lang . '/' . $uri;
                }
            }
            Route::get(
                $uri,
                array(
                    'as' => $lang.'.partners',
                    'uses' => 'TypiCMS\Modules\Partners\Controllers\PublicController@index'
                )
            );
            Route::get(
                $uri.'/{slug}',
                array(
                    'as' => $lang.'.partners.slug',
                    'uses' => 'TypiCMS\Modules\Partners\Controllers\PublicController@show'
                )
            );
        }
    });
}

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('partners', 'TypiCMS\Modules\Partners\Controllers\AdminController');
    Route::post('partners/sort', array('as' => 'admin.partners.sort', 'uses' => 'TypiCMS\Modules\Partners\Controllers\AdminController@sort'));
});
