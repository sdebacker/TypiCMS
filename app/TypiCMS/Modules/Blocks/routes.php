<?php
Route::model('blocks', 'TypiCMS\Modules\Blocks\Models\Block');

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Blocks\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('blocks', 'AdminController');
    }
);

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'blocks',
        'TypiCMS\Modules\Blocks\Controllers\ApiController'
    );
});

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'blocks',
        'TypiCMS\Modules\Blocks\Controllers\ApiController'
    );
});
