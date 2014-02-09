<?php 
Route::model('files', 'TypiCMS\Modules\Files\Models\File');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('files', 'TypiCMS\Modules\Files\Controllers\Admin\FilesController');
	Route::post('files/sort', array('as' => 'admin.files.sort', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@sort'));
	Route::post('files/upload', array('as' => 'admin.files.upload', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@upload'));
});
