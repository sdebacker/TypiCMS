<?php
Route::bind('blocks', function ($value) {
    return TypiCMS\Modules\Blocks\Models\Block::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

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
