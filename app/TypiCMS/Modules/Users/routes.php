<?php
/**
 * Login / logout.
 */
Route::get('users/login', array('as' => 'login', 'uses' => 'TypiCMS\Modules\Users\Controllers\AdminController@getLogin'));
Route::post('users/login', 'TypiCMS\Modules\Users\Controllers\AdminController@postLogin');

Route::get('users/logout', array('as' => 'logout', 'uses' => 'TypiCMS\Modules\Users\Controllers\AdminController@getLogout'));

Route::group(array('before' => 'users.register'), function () {
    Route::get('users/register', array('as' => 'register', 'uses' => 'TypiCMS\Modules\Users\Controllers\AdminController@getRegister'));
    Route::post('users/register', 'TypiCMS\Modules\Users\Controllers\AdminController@postRegister');
});

Route::get('users/activate/{userid}/{activationCode}', array('as' => 'activate', 'uses' => 'TypiCMS\Modules\Users\Controllers\AdminController@getActivate'));

Route::get('users/resetpassword', array('as' => 'resetpassword', 'uses' => 'TypiCMS\Modules\Users\Controllers\AdminController@getResetpassword'));
Route::post('users/resetpassword', 'TypiCMS\Modules\Users\Controllers\AdminController@postResetpassword');

Route::get('users/changepassword/{userid}/{resetcode}', array('as' => 'changepassword', 'uses' => 'TypiCMS\Modules\Users\Controllers\AdminController@getChangepassword'));
Route::post('users/changepassword/{userid}/{resetcode}', 'TypiCMS\Modules\Users\Controllers\AdminController@postChangepassword');

/**
 * Admin routes.
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource('users', 'TypiCMS\Modules\Users\Controllers\AdminController');
});
