<?php
if (Request::segment(1) != 'admin' && Request::segment(1) != 'api') {

    Route::bind('categories', function ($slug) {
        $categRepo = App::make('TypiCMS\Modules\Categories\Repositories\CategoryInterface');
        return $categRepo->bySlug($slug);
    });

} else {

    Route::bind('categories', function ($value) {
        return TypiCMS\Modules\Categories\Models\Category::where('id', $value)
            ->with('translations')
            ->firstOrFail();
    });

}

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Categories\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('categories', 'AdminController');
        Route::post('categories/sort', array('as' => 'admin.categories.sort', 'uses' => 'AdminController@sort'));
    }
);

Route::group(array('prefix'=>'api/v1'), function() {
    Route::resource(
        'categories',
        'TypiCMS\Modules\Categories\Controllers\ApiController'
    );
});
