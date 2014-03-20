<?php
Route::bind('pages', function ($value, $route) {
    return TypiCMS\Modules\Pages\Models\Page::where('id', $value)
        ->with('translations')
        ->files(true)
        ->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('pages', 'TypiCMS\Modules\Pages\Controllers\Admin\PagesController');
    Route::post('pages/sort', array('as' => 'admin.pages.sort', 'uses' => 'TypiCMS\Modules\Pages\Controllers\Admin\PagesController@sort'));
});

Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
	Route::get('{lang}', 'TypiCMS\Modules\Pages\Controllers\PagesController@homepage');
	Route::get('{lang}/{slug}', 'TypiCMS\Modules\Pages\Controllers\PagesController@slug');
	Route::get('{lang}/{niv1}/{slug}', 'TypiCMS\Modules\Pages\Controllers\PagesController@niv1');
	Route::get('{lang}/{niv1}/{niv2}/{slug}', 'TypiCMS\Modules\Pages\Controllers\PagesController@niv2');
});
