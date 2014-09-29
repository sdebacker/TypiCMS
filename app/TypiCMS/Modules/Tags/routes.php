<?php
Route::model('tags', 'TypiCMS\Modules\Tags\Models\Tag');

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Tags\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('tags', 'AdminController');
    }
);

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'tags',
        'TypiCMS\Modules\Tags\Controllers\ApiController'
    );
});
