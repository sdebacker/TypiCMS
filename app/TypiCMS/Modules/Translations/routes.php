<?php
Route::bind('translations', function ($value, $route) {
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
