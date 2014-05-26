<?php
Route::model('files', 'TypiCMS\Modules\Files\Models\File');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {

    Route::resource('files', 'TypiCMS\Modules\Files\Controllers\AdminController');

    Route::post(
        'files/sort',
        array(
            'as' => 'admin.files.sort',
            'uses' => 'TypiCMS\Modules\Files\Controllers\AdminController@sort'
        )
    );
    Route::post(
        'files/upload',
        array(
            'as' => 'admin.files.upload',
            'uses' => 'TypiCMS\Modules\Files\Controllers\AdminController@upload'
        )
    );

});
