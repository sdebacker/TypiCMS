<?php
Route::bind('menus', function ($value) {
    return TypiCMS\Modules\Menus\Models\Menu::where('id', $value)
        ->with('translations', 'menulinks', 'menulinks.translations')
        ->firstOrFail();
});

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Menus\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('menus', 'AdminController');
    }
);

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'menus',
        'TypiCMS\Modules\Menus\Controllers\ApiController'
    );
});
