<?php
Route::bind('contacts', function ($value, $route) {
    return TypiCMS\Modules\Contacts\Models\Contact::where('id', $value)
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(
        array(
            'before'    => 'visitor.publicAccess',
            'namespace' => 'TypiCMS\Modules\Contacts\Controllers',
        ),
        function () {
            $routes = app('TypiCMS.routes');
            foreach (Config::get('app.locales') as $lang) {
                if (isset($routes['contacts'][$lang])) {
                    $uri = $routes['contacts'][$lang];
                } else {
                    $uri = 'contacts';
                    if (Config::get('app.locale_in_url')) {
                        $uri = $lang . '/' . $uri;
                    }
                }
                Route::get($uri, array('as' => $lang.'.contacts', 'uses' => 'PublicController@index'));
            }
        }
    );
}

Route::post(
    'contact-store_',
    array(
        'before' => 'csrf',
        'as'     => 'contacts.index',
        'uses'   => 'TypiCMS\Modules\Contacts\Controllers\PublicController@store'
    )
);

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Contacts\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('contacts', 'AdminController');
    }
);
