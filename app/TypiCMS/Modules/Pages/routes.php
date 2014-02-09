<?php 
Route::model('pages', 'TypiCMS\Modules\Pages\Models\Page');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('pages', 'TypiCMS\Modules\Pages\Controllers\Admin\PagesController');
	Route::post('pages/sort', array('as' => 'admin.pages.sort', 'uses' => 'TypiCMS\Modules\Pages\Controllers\Admin\PagesController@sort'));
});
