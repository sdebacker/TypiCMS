<?php 
/**
 * Login / logout.
 */
Route::get('users/login', array('as' => 'login', 'uses' => 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@getLogin'));
Route::post('users/login', 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@postLogin');

Route::get('users/logout', array('as' => 'logout', 'uses' => 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@getLogout'));

Route::group(array('before' => 'users.register'), function()
{
	Route::get('users/register', array('as' => 'register', 'uses' => 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@getRegister'));
	Route::post('users/register', 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@postRegister');
});

Route::get('users/activate/{userid}/{activationCode}', array('as' => 'activate', 'uses' => 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@getActivate'));

Route::get('users/resetpassword', array('as' => 'resetpassword', 'uses' => 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@getResetpassword'));
Route::post('users/resetpassword', 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@postResetpassword');

Route::get('users/changepassword/{userid}/{resetcode}', array('as' => 'changepassword', 'uses' => 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@getChangepassword'));
Route::post('users/changepassword/{userid}/{resetcode}', 'TypiCMS\Modules\Users\Controllers\Admin\UsersController@postChangepassword');

/**
 * Admin routes.
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
	Route::resource('users', 'TypiCMS\Modules\Users\Controllers\Admin\UsersController');
});
