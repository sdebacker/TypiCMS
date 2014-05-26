<?php
Route::bind('galleries', function ($value, $route) {
    return TypiCMS\Modules\Galleries\Models\Gallery::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
        foreach (App::make('TypiCMS.routes')['galleries'] as $lang => $uri) {
            Route::get(
                $uri,
                array(
                    'as' => $lang.'.galleries',
                    'uses' => 'TypiCMS\Modules\Galleries\Controllers\PublicController@index'
                )
            );
            Route::get(
                $uri.'/{slug}',
                array(
                    'as' => $lang.'.galleries.slug',
                    'uses' => 'TypiCMS\Modules\Galleries\Controllers\PublicController@show'
                )
            );
        }
    });
}

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource(
        'galleries',
        'TypiCMS\Modules\Galleries\Controllers\AdminController'
    );
});
