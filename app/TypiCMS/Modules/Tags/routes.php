<?php
Route::model('tags', 'TypiCMS\Modules\Tags\Models\Tag');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('tags', 'TypiCMS\Modules\Tags\Controllers\Admin\TagsController');
});
