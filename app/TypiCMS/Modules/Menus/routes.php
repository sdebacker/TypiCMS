<?php
Route::bind('menus', function ($value, $route) {
    return TypiCMS\Modules\Menus\Models\Menu::with('menulinks')
        ->where('id', $value)
        ->firstOrFail();
});

Route::group(
    array(
        'before'    => 'auth.admin',
        'namespace' => 'TypiCMS\Modules\Menus\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('menus', 'AdminController');
    }
);
