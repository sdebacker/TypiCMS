<?php
Route::model('menulinks', 'TypiCMS\Modules\Menulinks\Models\Menulink');

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('menus.menulinks', 'TypiCMS\Modules\Menulinks\Controllers\AdminController');
    Route::post('menus/{menus}/menulinks/sort', array('as' => 'admin.menus.menulinks.sort', 'uses' => 'TypiCMS\Modules\Menulinks\Controllers\AdminController@sort'));
});

Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {

    if (! App::runningInConsole()) {

        // Build routes from menulinks (modules)
        $menulinksArray = App::make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')->getForRoutes();

        // projects routes
        if (isset($menulinksArray['projects'])) {
            foreach ($menulinksArray['projects'] as $lang => $uri) {
                Route::get($uri, array('as' => $lang.'.projects', 'uses' => 'TypiCMS\Modules\Projects\Controllers\PublicController@index'));
                Route::get($uri.'/{categories}', array('as' => $lang.'.projects.categories', 'uses' => 'TypiCMS\Modules\Projects\Controllers\PublicController@index'));
                Route::get($uri.'/{categories}/{slug}', array('as' => $lang.'.projects.categories.slug', 'uses' => 'TypiCMS\Modules\Projects\Controllers\PublicController@show'));
            }
            unset($menulinksArray['projects']);
        }

        // modules routes
        foreach ($menulinksArray as $module => $moduleArray) {
            foreach ($moduleArray as $lang => $uri) {
                Route::get($uri, array('as' => $lang.'.'.$module, 'uses' => 'TypiCMS\Modules\\'.ucfirst($module).'\Controllers\\PublicController@index'));
                Route::get($uri.'/{slug}', array('as' => $lang.'.'.$module.'.slug', 'uses' => 'TypiCMS\Modules\\'.ucfirst($module).'\Controllers\\PublicController@show'));
            }
        }

    }

});
