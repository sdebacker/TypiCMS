<?php
Route::bind('projects', function ($value, $route) {
    return TypiCMS\Modules\Projects\Models\Project::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
        $routes = app('TypiCMS.routes');
        foreach (Config::get('app.locales') as $lang) {
            $uri = (array_key_exists('projects', $routes)) ? $routes['projects'][$lang] : $lang.'/projects' ;
            Route::get(
                $uri,
                array(
                    'as' => $lang.'.projects',
                    'uses' => 'TypiCMS\Modules\Projects\Controllers\PublicController@index'
                )
            );
            Route::get(
                $uri.'/{categories}',
                array(
                    'as' => $lang.'.projects.categories',
                    'uses' => 'TypiCMS\Modules\Projects\Controllers\PublicController@index'
                )
            );
            Route::get(
                $uri.'/{categories}/{slug}',
                array(
                    'as' => $lang.'.projects.categories.slug',
                    'uses' => 'TypiCMS\Modules\Projects\Controllers\PublicController@show'
                )
            );
        }
    });
}

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource(
        'projects',
        'TypiCMS\Modules\Projects\Controllers\AdminController'
    );
    Route::post(
        'projects/sort',
        array(
            'as' => 'admin.projects.sort',
            'uses' => 'TypiCMS\Modules\Projects\Controllers\AdminController@sort'
        )
    );
});
