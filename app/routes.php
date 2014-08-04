<?php
/* 
 * Route filter "publicSide"
 */
foreach (Config::get('app.locales') as $locale) {
    Route::when($locale, 'publicSide');
    Route::when($locale . '/*', 'publicSide');
}

/**
 * Route filter admin side
 */
Route::when('admin', 'adminSide');
Route::when('admin/*', 'adminSide');
