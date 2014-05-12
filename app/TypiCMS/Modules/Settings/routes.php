<?php
Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('settings', 'TypiCMS\Modules\Settings\Controllers\Admin\SettingsController');
    Route::get('backup', array('as' => 'backup', 'uses' => 'TypiCMS\Modules\Settings\Controllers\Admin\SettingsController@backup'));
    Route::get('cache/clear', array('as' => 'cache.clear', 'uses' => 'TypiCMS\Modules\Settings\Controllers\Admin\SettingsController@clearCache'));
});
