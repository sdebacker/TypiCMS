<?php
/* 
 * Route filter "isLocaleOnline"
 */
foreach (Config::get('app.locales') as $locale) {
    Route::when($locale, 'isLocaleOnline');
    Route::when($locale . '/*', 'isLocaleOnline');
}

/**
 * Route filter admin side
 */
Route::when('admin', 'admin');
Route::when('admin/*', 'admin');
