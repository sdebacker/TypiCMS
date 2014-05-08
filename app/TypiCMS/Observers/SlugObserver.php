<?php
namespace TypiCMS\Observers;

class SlugObserver
{

    public function creating($model)
    {
        // slug = null si vide
        $slug = ($model->slug) ? $model->slug : null ;
        $model->slug = $slug;

        if ($slug) {
            $i = 0;
            // Check uri is unique
            while ($model::where('slug', $model->slug)->where('locale', $model->locale)->first()) {
                $i++;
                // increment slug if exists
                $model->slug = $slug.'-'.$i;
            }
        }
    }

    public function updating($model)
    {
        // slug = null si vide
        $slug = ($model->slug) ? $model->slug : null ;
        $model->slug = $slug;

        if ($slug) {
            $i = 0;
            // Check uri is unique
            while (
                $model::where('slug', $model->slug)
                    ->where('id', '!=', $model->id)
                    ->where('locale', $model->locale)
                    ->first()
                ) {
                $i++;
                // increment slug if exists
                $model->slug = $slug.'-'.$i;
            }
        }
    }
}
