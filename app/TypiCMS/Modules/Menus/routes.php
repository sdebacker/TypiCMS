<?php
Route::bind('menus', function ($value, $route) {
    return TypiCMS\Modules\Menus\Models\Menu::with('menulinks')
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
