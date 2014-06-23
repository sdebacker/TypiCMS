<?php
Route::model('tags', 'TypiCMS\Modules\Tags\Models\Tag');

Route::group(
    array(
        'before'    => 'auth.admin',
        'namespace' => 'TypiCMS\Modules\Tags\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('tags', 'AdminController');
    }
);
