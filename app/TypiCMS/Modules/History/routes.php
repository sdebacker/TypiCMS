<?php
Route::group(['prefix'=>'api'], function() {
    Route::resource(
        'history',
        'TypiCMS\Modules\History\Controllers\ApiController',
        ['only' => ['index']]
    );
});
