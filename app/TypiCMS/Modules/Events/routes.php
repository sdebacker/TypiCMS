<?php
Route::bind('events', function ($value, $route) {
    return TypiCMS\Modules\Events\Models\Event::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
        foreach (App::make('TypiCMS.routes')['events'] as $lang => $uri) {
            Route::get(
                $uri,
                array(
                    'as' => $lang.'.events',
                    'uses' => 'TypiCMS\Modules\Events\Controllers\PublicController@index'
                )
            );
            Route::get(
                $uri.'/{slug}',
                array(
                    'as' => $lang.'.events.slug',
                    'uses' => 'TypiCMS\Modules\Events\Controllers\PublicController@show'
                )
            );
        }
    });
}

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource(
        'events',
        'TypiCMS\Modules\Events\Controllers\AdminController'
    );
});
