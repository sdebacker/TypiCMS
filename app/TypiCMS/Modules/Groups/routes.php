<?php
Route::group(
    array(
        'before'    => 'auth.admin',
        'namespace' => 'TypiCMS\Modules\Groups\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('groups', 'AdminController');
    }
);
