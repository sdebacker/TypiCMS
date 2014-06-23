<?php
Route::model('blocks', 'TypiCMS\Modules\Blocks\Models\Block');

Route::group(
    array(
        'before'    => 'auth.admin',
        'namespace' => 'TypiCMS\Modules\Blocks\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('blocks', 'AdminController');
    }
);
