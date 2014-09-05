<?php
namespace TypiCMS\Modules\Pages\Models;

use Config;
use Eloquent;

class PageTranslation extends Eloquent
{

    /**
     * Observers
     */
    public static function boot()
    {
        parent::boot();

        $self = __CLASS__;

        static::creating(function ($model) use ($self) {
            // Build page's URI
            $model->uri = null;
            if ($model->slug) {

                $model->uri = $model->slug;

                if (Config::get('app.locale_in_url')) {
                    $model->uri = $model->locale . '/' . $model->uri;
                }

                $i = 0;
                // Check uri is unique
                while ($self::where('uri', $model->uri)->first()) {
                    $i++;
                    // increment uri if exists
                    $model->uri = $model->slug . '-' . $i;
                    if (Config::get('app.locale_in_url')) {
                        $model->uri = $model->locale . '/' . $model->uri;
                    }
                }

            }
        });

        static::updating(function ($model) use ($self) {
            $original = $model->getOriginal();

            $model->uri = ($model->uri) ? $model->uri : null ;

            // If slug has changed
            if ($model->slug != $original['slug']) {

                // Update page URI
                $array = explode('/', $model->uri);
                array_pop($array);
                $array[] = $model->slug;
                $uri = implode('/', $array);

                $model->uri = $uri;

                $i = 0;
                // Check uri is unique
                while ($self::where('uri', $model->uri)->first()) {
                    $i++;
                    // increment uri if exists
                    $model->uri = $uri.'-'.$i;
                }

            }

        });

    }
}
