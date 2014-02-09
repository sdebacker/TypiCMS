<?php 
Route::model('menulinks', 'TypiCMS\Modules\Menulinks\Models\Menulink');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('menus.menulinks', 'TypiCMS\Modules\Menulinks\Controllers\Admin\MenulinksController');
	Route::post('menus/{menus}/menulinks/sort', array('as' => 'admin.menus.menulinks.sort', 'uses' => 'TypiCMS\Modules\Menulinks\Controllers\Admin\MenulinksController@sort'));
});
