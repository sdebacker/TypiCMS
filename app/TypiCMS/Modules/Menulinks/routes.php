<?php
Route::model('menulinks', 'TypiCMS\Modules\Menulinks\Models\Menulink');

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Menulinks\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('menus.menulinks', 'AdminController');
        Route::post(
            'menus/{menus}/menulinks/sort',
            array('as' => 'admin.menus.menulinks.sort', 'uses' => 'AdminController@sort')
        );
    }
);
