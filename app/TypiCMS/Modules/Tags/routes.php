<?php 

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
	Route::resource('tags', 'TypiCMS\Modules\Tags\Controllers\Admin\TagsController');
});
