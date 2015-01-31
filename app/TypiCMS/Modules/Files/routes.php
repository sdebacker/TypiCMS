<?php
Route::bind('files', function ($value) {
    return TypiCMS\Modules\Files\Models\File::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

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

Route::group(array('prefix'=>'api'), function() {
    Route::resource(
        'files',
        'TypiCMS\Modules\Files\Controllers\ApiController'
    );
});
