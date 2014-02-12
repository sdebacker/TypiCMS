<?php 
Route::model('files', 'TypiCMS\Modules\Files\Models\File');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('files', 'TypiCMS\Modules\Files\Controllers\Admin\FilesController');
	Route::post('files/sort', array('as' => 'admin.files.sort', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@sort'));
	Route::post('files/upload', array('as' => 'admin.files.upload', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@upload'));

	Route::get('news/{news}/files', array('as' => 'admin.news.files.index', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@index'));
	Route::get('pages/{pages}/files', array('as' => 'admin.pages.files.index', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@index'));
	Route::get('events/{events}/files', array('as' => 'admin.events.files.index', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@index'));
	Route::get('partners/{partners}/files', array('as' => 'admin.partners.files.index', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@index'));
	Route::get('projects/{projects}/files', array('as' => 'admin.projects.files.index', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@index'));
});
