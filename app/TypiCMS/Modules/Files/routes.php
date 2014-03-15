<?php 
Route::model('files', 'TypiCMS\Modules\Files\Models\File');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
    Route::get('files', array('as' => 'admin.files.index', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@index'));
    Route::post('files/sort', array('as' => 'admin.files.sort', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@sort'));
    Route::post('files/upload', array('as' => 'admin.files.upload', 'uses' => 'TypiCMS\Modules\Files\Controllers\Admin\FilesController@upload'));

    Route::resource('news.files', 'TypiCMS\Modules\Files\Controllers\Admin\FilesController');
    Route::resource('pages.files', 'TypiCMS\Modules\Files\Controllers\Admin\FilesController');
    Route::resource('events.files', 'TypiCMS\Modules\Files\Controllers\Admin\FilesController');
    Route::resource('projects.files', 'TypiCMS\Modules\Files\Controllers\Admin\FilesController');
});
