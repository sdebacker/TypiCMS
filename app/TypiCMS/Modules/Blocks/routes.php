<?php
Route::model('blocks', 'TypiCMS\Modules\Blocks\Models\Block');

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Blocks\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('blocks', 'AdminController');
    }
);
