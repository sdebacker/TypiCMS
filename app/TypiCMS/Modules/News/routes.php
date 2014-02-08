<?php 
Route::model('news', 'TypiCMS\Modules\News\Models\News');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('news', 'TypiCMS\Modules\News\Controllers\Admin\NewsController');
});
