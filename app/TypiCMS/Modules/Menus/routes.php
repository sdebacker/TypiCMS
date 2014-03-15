<?php 
Route::bind('menus', function($value, $route){
    return TypiCMS\Modules\Menus\Models\Menu::with('menulinks')
        ->where('id', $value)
        ->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
    Route::resource('menus', 'TypiCMS\Modules\Menus\Controllers\Admin\MenusController');
});
