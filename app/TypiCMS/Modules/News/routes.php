<?php
Route::bind('news', function ($value, $route) {
    return TypiCMS\Modules\News\Models\News::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(
        array(
            'before'    => 'visitor.publicAccess',
            'namespace' => 'TypiCMS\Modules\News\Controllers',
        ),
        function () {
            $routes = app('TypiCMS.routes');
            foreach (Config::get('app.locales') as $lang) {
                if (isset($routes['news'][$lang])) {
                    $uri = $routes['news'][$lang];
                } else {
                    $uri = 'news';
                    if (Config::get('app.locale_in_url')) {
                        $uri = $lang . '/' . $uri;
                    }
                }
                Route::get($uri, array('as' => $lang.'.news', 'uses' => 'PublicController@index'));
                Route::get($uri.'/{slug}', array('as' => $lang.'.news.slug', 'uses' => 'PublicController@show'));
            }
        }
    );
}

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\News\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('news', 'AdminController');
    }
);
