<?php
Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::get('/', array('as' => 'dashboard', 'uses' => 'TypiCMS\Modules\Dashboard\Controllers\Admin\DashboardController@index'));
});
