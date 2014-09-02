<?php
Route::bind('projects', function ($value, $route) {
    return TypiCMS\Modules\Projects\Models\Project::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(
        array(
            'before'    => 'visitor.publicAccess',
            'namespace' => 'TypiCMS\Modules\Projects\Controllers',
        ),
        function () {
            $routes = app('TypiCMS.routes');
            foreach (Config::get('app.locales') as $lang) {
                if (isset($routes['projects'][$lang])) {
                    $uri = $routes['projects'][$lang];
                } else {
                    $uri = 'projects';
                    if (Config::get('app.locale_in_url')) {
                        $uri = $lang . '/' . $uri;
                    }
                }
                Route::get(
                    $uri,
                    array('as' => $lang.'.projects', 'uses' => 'PublicController@index')
                );
                Route::get(
                    $uri.'/{categories}',
                    array('as' => $lang.'.projects.categories', 'uses' => 'PublicController@index')
                );
                Route::get(
                    $uri.'/{categories}/{slug}',
                    array('as' => $lang.'.projects.categories.slug', 'uses' => 'PublicController@show')
                );
            }
        }
    );
}

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Projects\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('projects', 'AdminController');
        Route::post('projects/sort', array('as' => 'admin.projects.sort', 'uses' => 'AdminController@sort'));
    }
);
