<?php 

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::get('tags', array('as' => 'admin.tags.index', 'uses' => 'TypiCMS\Modules\Tags\Controllers\Admin\TagsController@index'));
});
