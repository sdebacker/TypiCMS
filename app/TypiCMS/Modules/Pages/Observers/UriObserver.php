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

            $model->uri = $model->slug;

            if (Config::get('app.locale_in_url')) {
                $model->uri = $model->locale . '/' . $model->uri;
            }

            $i = 0;
            // Check uri is unique
            while (PageTranslation::where('uri', $model->uri)->count()) {
                $i++;
                // increment uri if exists
                $model->uri = $model->slug . '-' . $i;
                if (Config::get('app.locale_in_url')) {
                    $model->uri = $model->locale . '/' . $model->uri;
                }
            }

        }

    }

    /**
     * On update, update uri
     * 
     * @param  PageTranslation $model
     * @return void
     */
    public function updating(PageTranslation $model)
    {

        // if uri == '', set it to null before insert it to DB.
        $model->uri = $model->uri ? : null ;

        // If slug has changed
        if ($model->isDirty('slug')) {

            // Explode uri string to array
            $array = explode('/', $model->uri);

            // remove last value of array
            array_pop($array);

            // add slug to array
            $array[] = $model->slug;

            // rebuild uri string
            $uri = implode('/', $array);

            $model->uri = $uri;

            $i = 0;

            // Check if uri is unique
            while (PageTranslation::where('uri', $model->uri)->count()) {
                $i++;
                // increment uri if exists
                $model->uri = $uri . '-' . $i;
            }

        }

    }

}
