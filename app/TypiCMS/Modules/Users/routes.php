<?php 
Route::model('places', 'TypiCMS\Modules\Places\Models\Place');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('places', 'TypiCMS\Modules\Places\Controllers\Admin\PlacesController');
	Route::post('places/sort', array('as' => 'admin.places.sort', 'uses' => 'TypiCMS\Modules\Places\Controllers\Admin\PlacesController@sort'));
});
