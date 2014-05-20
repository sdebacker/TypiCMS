<?php
Route::model('places', 'TypiCMS\Modules\Places\Models\Place');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('places', 'TypiCMS\Modules\Places\Controllers\AdminController');
    Route::post('places/sort', array('as' => 'admin.places.sort', 'uses' => 'TypiCMS\Modules\Places\Controllers\AdminController@sort'));
});
