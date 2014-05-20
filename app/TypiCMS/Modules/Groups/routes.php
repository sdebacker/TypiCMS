<?php

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('groups', 'TypiCMS\Modules\Groups\Controllers\AdminController');
});
