<?php
Route::bind('contacts', function ($value, $route) {
    return TypiCMS\Modules\Contacts\Models\Contact::where('id', $value)
        ->firstOrFail();
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('contacts', 'TypiCMS\Modules\Contacts\Controllers\AdminController');
});

Route::post('contact-store_', array('as' => 'contacts.index', 'uses' => 'TypiCMS\Modules\Contacts\Controllers\PublicController@store'));
