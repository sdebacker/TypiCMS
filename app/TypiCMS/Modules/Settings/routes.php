<?php
Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Settings\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('settings', 'AdminController');
        Route::get('backup', array('as' => 'backup', 'uses' => 'AdminController@backup'));
        Route::get('cache/clear', array('as' => 'cache.clear', 'uses' => 'AdminController@clearCache'));
    }
);
