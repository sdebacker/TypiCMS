<?php 
Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
	Route::resource('settings', 'TypiCMS\Modules\Settings\Controllers\Admin\SettingsController');
});
