<?php
namespace TypiCMS\Modules\Pages\Observers;

use Config;
use DB;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Pages\Models\Page;

class SortObserver
{

    /**
     * On update, update children uris
     * 
     * @param  Page $model
     * @return void
     */
    public function updating(Page $model)
    {
        if ($model->isDirty('page_id')) {

            $parentPage = $model->parent;

            foreach (Config::get('app.locales') as $locale) {

                $slug = $model->translate($locale)->slug;

                if ($parentPage) {
                    $uri = $parentPage->translate($locale)->uri . '/' . $slug;
                } else {
                    if (Config::get('app.locale_in_url')) {
                        $uri = $locale . '/' . $slug;
                    }
                }

                $model->translate($locale)->uri = $uri;

            }
            
            $this->updateChildren($model);

        }

    }

    /**
     * Update children
     * 
     * @param  Model $model eloquent
     * @return mixed false or void
     */
    private function updateChildren(Model $model)
    {
        foreach ($model->children as $child) {
            foreach (Config::get('app.locales') as $locale) {
                $child->translate($locale)->uri = $model->translate($locale)->uri . '/' . $child->translate($locale)->slug;
            }
            $child->save();
            if ($child->children()->count()) {
                $this->updateChildren($child);
            }
        }
    }
}
