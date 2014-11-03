<?php
Route::model('history', 'TypiCMS\Modules\History\Models\History');

Route::group(
    [
        'namespace' => 'TypiCMS\Modules\History\Controllers',
        'prefix'    => 'admin',
    ],
    function () {
        Route::resource('history', 'AdminController', ['only' => ['index']]);
    }
);

Route::group(['prefix'=>'api/v1'], function() {
    Route::resource(
        'history',
        'TypiCMS\Modules\History\Controllers\ApiController',
        ['only' => ['index']]
    );
});
