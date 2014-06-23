<?php
Route::bind('pages', function ($value, $route) {
    return TypiCMS\Modules\Pages\Models\Page::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

Route::group(
    array(
        'before'    => 'auth.admin',
        'namespace' => 'TypiCMS\Modules\Pages\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('pages', 'AdminController');
        Route::post('pages/sort', array('as' => 'admin.pages.sort', 'uses' => 'AdminController@sort'));
    }
);

Route::group(
    array(
        'before'    => 'auth.public|cache',
        'after'     => 'cache',
        'namespace' => 'TypiCMS\Modules\Pages\Controllers',
    ),
    function () {
        Route::get('{uri}', 'PublicController@uri')->where('uri', '(.*)');
    }
);
