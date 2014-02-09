<?php 
Route::model('events', 'TypiCMS\Modules\Events\Models\Event');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::resource('events', 'TypiCMS\Modules\Events\Controllers\Admin\EventsController');
});
