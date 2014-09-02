<?php
/**
 * Register routes filter classes
 */
Route::filter('public.checkLocale', 'TypiCMS\Filters\PublicFilter@checkLocale');
Route::filter('public.auth',        'TypiCMS\Filters\PublicFilter@auth');
Route::filter('admin.setLocale',    'TypiCMS\Filters\AdminFilter@setLocale');
Route::filter('users.mayRegister',  'TypiCMS\Filters\UsersFilter@mayRegister');
Route::filter('user.auth',          'TypiCMS\Filters\UsersFilter@auth');
Route::filter('user.hasAccess',     'TypiCMS\Filters\UsersFilter@hasAccess');
Route::filter('user.inGroup',       'TypiCMS\Filters\UsersFilter@inGroup');

/**
 * Route filter "public"
 */
foreach (Config::get('app.locales') as $locale) {
    Route::when($locale,      'public.checkLocale');
    Route::when($locale.'/*', 'public.checkLocale');
}

/**
 * Route filter admin side
 */
Route::when('admin',   'admin.setLocale|user.auth|user.hasAccess');
Route::when('admin/*', 'admin.setLocale|user.auth|user.hasAccess');
