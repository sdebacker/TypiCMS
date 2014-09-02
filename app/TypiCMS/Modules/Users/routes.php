<?php
/**
 * User registration
 */
Route::group(
    array(
        'before' => 'visitor.mayRegister',
        'namespace' => 'TypiCMS\Modules\Users\Controllers',
    ),
    function () {
        Route::get('users/register', array('as' => 'register', 'uses' => 'AdminController@getRegister'));
        Route::post('users/register', 'AdminController@postRegister');
    }
);

/**
 * Login
 * Logout
 * Activation
 * Request new password
 * Set new password
 */
Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Users\Controllers',
    ),
    function () {

        // Login
        Route::get('users/login', array('as' => 'login', 'uses' => 'AdminController@getLogin'));
        Route::post('users/login', 'AdminController@postLogin');

        // Logout
        Route::get('users/logout', array('as' => 'logout', 'uses' => 'AdminController@getLogout'));

        // Activation
        Route::get(
            'users/activate/{userid}/{activationCode}',
            array('as' => 'activate', 'uses' => 'AdminController@getActivate')
        );

        // Request new password
        Route::get(
            'users/resetpassword',
            array('as' => 'resetpassword', 'uses' => 'AdminController@getResetpassword')
        );
        Route::post('users/resetpassword', 'AdminController@postResetpassword');

        // Set new password
        Route::get(
            'users/changepassword/{userid}/{resetcode}',
            array('as' => 'changepassword', 'uses' => 'AdminController@getChangepassword')
        );
        Route::post('users/changepassword/{userid}/{resetcode}', 'AdminController@postChangepassword');
    }
);

/**
 * Admin routes
 */
Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Users\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('users', 'AdminController');
        // Update preferences
        Route::post('users/current/updatepreferences', 'AdminController@postUpdatePreferences');
    }
);
