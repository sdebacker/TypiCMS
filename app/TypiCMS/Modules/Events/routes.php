<?php
Route::bind('events', function ($value, $route) {
    return TypiCMS\Modules\Events\Models\Event::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('events', 'TypiCMS\Modules\Events\Controllers\AdminController');
});
