<?php
namespace TypiCMS\Modules\Pages\Observers;

use Config;
use DB;
use TypiCMS\Modules\Pages\Models\Page;
use TypiCMS\Modules\Pages\Models\PageTranslation;

class UriObserver
{

    /**
     * On create, update uri
     * 
     * @param  PageTranslation $model
     * @return void
     */
    public function creating(PageTranslation $model)
    {

        $model->uri = null;

        if ($model->slug) {

            $uri = $model->slug;

            if (Config::get('app.locale_in_url')) {
                $uri = $model->locale . '/' . $uri;
            }

            $model->uri = $this->incrementWhileExists($uri);

        }

    }

    /**
     * On update, change uri
     * 
     * @param  PageTranslation $model
     * @return void
     */
    public function updating(PageTranslation $model)
    {

        if ($model->slug) {

            $uri = $this->getParentUri($model) . '/' . $model->slug;

            $model->uri = $this->incrementWhileExists($uri);

        } else {

            $model->uri = null;

        }

    }

    /**
     * Get parent page’s URI
     *
     * @param  PageTranslation $model
     * @return string
     */
    private function getParentUri(PageTranslation $model)
    {
        if ($model->page->parent) {
            return $model->page->parent->translate($model->locale)->uri;
        }
        return $model->locale;
    }

    /**
     * Check if uri exists in all uris array
     *
     * @param  string $uri
     * @return bool
     */
    private function uriExists($uri)
    {
        if (in_array($uri, app('TypiCMS.pages.uris'))) {
            return true;
        }
        return false;
    }

    /**
     * Add '-x' on uri if it exists in page_translations table
     *  
     * @param  string $uri
     * @return string
     */
    private function incrementWhileExists($uri)
    {
        $originalUri = $uri;

        $i = 0;
        // Check if uri is unique
        while ($this->uriExists($uri)) {
            $i++;
            // increment uri if it exists
            $uri = $originalUri . '-' . $i;
        }

        return $uri;
    }
}
