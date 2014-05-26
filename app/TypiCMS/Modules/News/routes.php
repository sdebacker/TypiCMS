<?php
Route::bind('news', function ($value, $route) {
    return TypiCMS\Modules\News\Models\News::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
        foreach (App::make('TypiCMS.routes')['news'] as $lang => $uri) {
            Route::get(
                $uri,
                array(
                    'as' => $lang.'.news',
                    'uses' => 'TypiCMS\Modules\News\Controllers\PublicController@index'
                )
            );
            Route::get(
                $uri.'/{slug}',
                array(
                    'as' => $lang.'.news.slug',
                    'uses' => 'TypiCMS\Modules\News\Controllers\PublicController@show'
                )
            );
        }
    });
}

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource(
        'news',
        'TypiCMS\Modules\News\Controllers\AdminController'
    );
});
