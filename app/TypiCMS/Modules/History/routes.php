<?php
Route::group(['prefix'=>'api/v1'], function() {
    Route::resource(
        'history',
        'TypiCMS\Modules\History\Controllers\ApiController',
        ['only' => ['index']]
    );
});
