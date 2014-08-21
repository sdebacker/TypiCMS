<?php
Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Groups\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('groups', 'AdminController');
    }
);
