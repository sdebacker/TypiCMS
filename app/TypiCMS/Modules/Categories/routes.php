<?php
if (Request::segment(1) != 'admin') {
    Route::bind('categories', function ($value, $route) {
        return TypiCMS\Modules\Categories\Models\Category::select('categories.id AS id', 'slug', 'locale', 'status')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('slug', $value)
            ->where('locale', App::getLocale())
            ->where('status', 1)
            ->firstOrFail();
    });

} else {

    Route::model('categories', 'TypiCMS\Modules\Categories\Models\Category');

}

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource(
        'categories',
        'TypiCMS\Modules\Categories\Controllers\AdminController'
    );
    Route::post(
        'categories/sort',
        array(
            'as' => 'admin.categories.sort',
            'uses' => 'TypiCMS\Modules\Categories\Controllers\AdminController@sort'
        )
    );
});
