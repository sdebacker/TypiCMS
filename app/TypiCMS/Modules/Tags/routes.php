<?php 

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('tags', 'TypiCMS\Modules\Tags\Controllers\Admin\TagsController');
});
