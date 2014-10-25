<?php
namespace TypiCMS\Modules\Pages\Observers;

use Config;
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

            $model->uri = $this->incrementWhileExists($uri, $model->id);

        } else {

            $model->uri = null;

        }

    }

    /**
     * After update, update children’s uri
     * 
     * @param  PageTranslation $model
     * @return void
     */
    public function updated(PageTranslation $model)
    {

        $this->updateChildren($model->page);

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
     * @param  string  $uri
     * @param  integer $id
     * @return bool
     */
    private function uriExists($uri, $id)
    {
        $uris = app('TypiCMS.pages.uris');
        unset($uris[$id]);
        if (in_array($uri, $uris)) {
            return true;
        }
        return false;
    }

    /**
     * Add '-x' on uri if it exists in page_translations table
     *  
     * @param  string  $uri
     * @param  integer $id in case of update, except this id
     * @return string
     */
    private function incrementWhileExists($uri, $id = 0)
    {
        $originalUri = $uri;

        $i = 0;
        // Check if uri is unique
        while ($this->uriExists($uri, $id)) {
            $i++;
            // increment uri if it exists
            $uri = $originalUri . '-' . $i;
        }

        return $uri;
    }

    /**
     * Recursive method for children’s uri update
     * 
     * @param  Page $page
     * @return void
     */
    private function updateChildren(Page $page)
    {
        foreach ($page->children as $child) {
            foreach (Config::get('app.locales') as $locale) {
                $child->translate($locale)->uri = null;
            }
            $child->save();
            $this->updateChildren($child);
        }
    }
}
