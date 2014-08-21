<?php
/**
 * Sitemap
 */
Route::get(
    'sitemap.xml',
    array(
        'as'   => 'sitemap',
        'uses' => 'TypiCMS\Modules\Sitemap\Controllers\PublicController@generate'
    )
);
