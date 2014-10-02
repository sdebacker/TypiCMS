<?php
Route::bind('menus', function ($value, $route) {
    return TypiCMS\Modules\Menus\Models\Menu::with('menulinks', 'menulinks.translations')
        ->where('id', $value)
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
