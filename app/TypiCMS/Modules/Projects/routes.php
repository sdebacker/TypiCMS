<?php 
Route::model('projects', 'TypiCMS\Modules\Projects\Models\Project');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('projects', 'TypiCMS\Modules\Projects\Controllers\Admin\ProjectsController');
	Route::post('projects/sort', array('as' => 'admin.projects.sort', 'uses' => 'TypiCMS\Modules\Projects\Controllers\Admin\ProjectsController@sort'));
});
