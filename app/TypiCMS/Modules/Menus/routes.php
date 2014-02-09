<?php 
Route::model('menus', 'TypiCMS\Modules\Menus\Models\Menu');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('menus', 'TypiCMS\Modules\Menus\Controllers\Admin\MenusController');
});
