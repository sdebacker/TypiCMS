<?php
/**
 * Sitemap
 */
Route::get('sitemap', array('as' => 'sitemap', 'uses' => 'TypiCMS\Modules\Sitemap\Controllers\PublicController@generate'));
