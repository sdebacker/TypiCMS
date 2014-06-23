<?php
Route::group(
    array(
        'before'    => 'auth.admin',
        'namespace' => 'TypiCMS\Modules\Dashboard\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::get('/', array( 'as' => 'dashboard', 'uses' => 'AdminController@index'));
    }
);
