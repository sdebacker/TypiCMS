<?php
Route::model('blocks', 'TypiCMS\Modules\Blocks\Models\Block');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('blocks', 'TypiCMS\Modules\Blocks\Controllers\AdminController');
});
