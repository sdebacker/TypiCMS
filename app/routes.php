<?php
/* 
 * Route filter "isPublicLocaleOnline"
 */
foreach (Config::get('app.locales') as $locale) {
    Route::when($locale, 'isPublicLocaleOnline');
    Route::when($locale . '/*', 'isPublicLocaleOnline');
}
