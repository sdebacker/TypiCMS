<?php
Route::bind('menulinks', function ($value) {
    return TypiCMS\Modules\Menulinks\Models\Menulink::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Menulinks\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('menus.menulinks', 'AdminController');
        Route::post(
            'menulinks/sort',
            array('as' => 'admin.menulinks.sort', 'uses' => 'AdminController@sort')
        );
    }
);

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'menulinks',
        'TypiCMS\Modules\Menulinks\Controllers\ApiController'
    );
});
