<?php 

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('groups', 'TypiCMS\Modules\Groups\Controllers\Admin\GroupsController');
});
