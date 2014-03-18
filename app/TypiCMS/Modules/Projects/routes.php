<?php
Route::bind('projects', function ($value, $route) {
    return TypiCMS\Modules\Projects\Models\Project::where('id', $value)
        ->with('translations')
        ->files(true)
        ->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('projects', 'TypiCMS\Modules\Projects\Controllers\Admin\ProjectsController');
    Route::post('projects/sort', array('as' => 'admin.projects.sort', 'uses' => 'TypiCMS\Modules\Projects\Controllers\Admin\ProjectsController@sort'));
});
