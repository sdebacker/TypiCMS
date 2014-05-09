<?php
Route::bind('galleries', function ($value, $route) {
    return TypiCMS\Modules\Galleries\Models\Gallery::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('galleries', 'TypiCMS\Modules\Galleries\Controllers\Admin\GalleriesController');
});
