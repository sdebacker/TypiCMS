<?php
Route::bind('translations', function ($value) {
    return TypiCMS\Modules\Translations\Models\Translation::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Translations\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('translations', 'AdminController');
    }
);

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'translations',
        'TypiCMS\Modules\Translations\Controllers\ApiController'
    );
});
