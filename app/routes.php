<?php
/**
 * Register routes filter classes
 */
Route::filter('public.checkLocale', 'TypiCMS\Filters\PublicFilter@checkLocale');
Route::filter('public.auth',        'TypiCMS\Filters\PublicFilter@auth');
Route::filter('admin.setLocale',    'TypiCMS\Filters\AdminFilter@setLocale');
Route::filter('admin.auth',         'TypiCMS\Filters\AdminFilter@auth');
Route::filter('users.mayRegister',  'TypiCMS\Filters\UsersFilter@mayRegister');

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
Route::when('admin',   'admin.setLocale|admin.auth');
Route::when('admin/*', 'admin.setLocale|admin.auth');
