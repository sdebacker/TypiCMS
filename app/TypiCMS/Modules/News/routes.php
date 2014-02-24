<?php 
Route::bind('news', function($value, $route){
	return TypiCMS\Modules\News\Models\News::where('id', $value)
		->with('translations')
		->files(true)
		->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('news', 'TypiCMS\Modules\News\Controllers\Admin\NewsController');
});
