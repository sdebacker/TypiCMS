<?php
Route::bind('pages', function ($value, $route) {
    return TypiCMS\Modules\Pages\Models\Page::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('pages', 'TypiCMS\Modules\Pages\Controllers\Admin\PagesController');
    Route::post('pages/sort', array('as' => 'admin.pages.sort', 'uses' => 'TypiCMS\Modules\Pages\Controllers\Admin\PagesController@sort'));
});

Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
    Route::get('{uri}', 'TypiCMS\Modules\Pages\Controllers\PagesController@uri')->where('uri', '(.*)');
});
