<?php 
Route::model('menus', 'TypiCMS\Modules\Menus\Models\Menu');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
	Route::resource('menus', 'TypiCMS\Modules\Menus\Controllers\Admin\MenusController');
});
