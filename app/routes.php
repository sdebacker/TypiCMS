<?php
/* 
 * Check if 
 */
foreach (Config::get('app.locales') as $locale) {
    Route::when($locale, 'isPublicLocaleOnline');
    Route::when($locale . '/*', 'isPublicLocaleOnline');
}
