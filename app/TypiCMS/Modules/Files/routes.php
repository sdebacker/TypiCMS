<?php
Route::model('files', 'TypiCMS\Modules\Files\Models\File');

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Files\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('files', 'AdminController');
        Route::post('files/sort', array( 'as' => 'admin.files.sort', 'uses' => 'AdminController@sort'));
        Route::post('files/upload', array( 'as' => 'admin.files.upload', 'uses' => 'AdminController@upload'));
    }
);
