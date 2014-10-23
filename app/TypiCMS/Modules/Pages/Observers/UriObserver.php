<?php
namespace TypiCMS\Modules\Pages\Observers;

use Config;
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

        // if uri is an empty string, set it to null before inserting it to DB.
        $model->uri = $model->uri ? : null ;

        // Replace last segment of uri with new slug
        $uri = substr($model->uri, 0, strrpos($model->uri, '/') + 1) . $model->slug;

        $model->uri = $this->incrementWhileExists($uri);

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
        while (PageTranslation::where('uri', $uri)->count()) {
            $i++;
            // increment uri if exists
            $uri = $originalUri . '-' . $i;
        }

        return $uri;
    }
}
