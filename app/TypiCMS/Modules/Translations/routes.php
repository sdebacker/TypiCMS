<?php
Route::bind('translations', function ($value, $route) {
    return TypiCMS\Modules\Translations\Models\Translation::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('translations', 'TypiCMS\Modules\Translations\Controllers\AdminController');
});
