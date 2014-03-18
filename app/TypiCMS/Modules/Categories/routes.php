<?php
Route::model('categories', 'TypiCMS\Modules\Categories\Models\Category');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('categories', 'TypiCMS\Modules\Categories\Controllers\Admin\CategoriesController');
    Route::post('categories/sort', array('as' => 'admin.categories.sort', 'uses' => 'TypiCMS\Modules\Categories\Controllers\Admin\CategoriesController@sort'));
});
