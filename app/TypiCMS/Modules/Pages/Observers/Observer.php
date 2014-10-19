<?php
namespace TypiCMS\Modules\Pages\Observers;

use Config;
use DB;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Pages\Models\Page;

class Observer
{

    protected $urisAndSlugs = array();
    protected $flatUris = array();

    public function __construct()
    {
        $this->flatUris = $this->flatUris();
        $this->urisAndSlugs = $this->getAllUris();
    }

    /**
     * If a new homepage is defined, cancel previous homepage.
     * 
     * @param  Model $model eloquent
     * @return void
     */
    public function saving(Model $model)
    {
        if ($model->is_home) {
            $query = Page::where('is_home', 1);
            if ($model->id) {
                $query->where('id', '!=', $model->id);
            }
            $query->update(array('is_home' => 0));
        }
    }

    /**
     * On update, update children uris
     * 
     * @param  Model $model eloquent
     * @return void
     */
    public function updating(Model $model)
    {
        foreach (Config::get('app.locales') as $locale) {
            // print_r($model->getDirty());
            // if (! $model->isDirty($locale . '[uri]')) {
            //     continue;
            // }

            if ($parent = $model->parent()) {
                $uri = $parent->translate($locale)->uri . '/' . $model->translate($locale)->slug;
            } else {
                $uri = $model->translate($locale)->slug;
                if (Config::get('app.locale_in_url')) {
                    $uri = $locale . '/' . $uri;
                }
            }

            // Check that uri is unique
            $tmpUri = $uri;
            $i = 0;
            while ($this->uriExists($tmpUri, $model->id)) {
                $i ++;
                // increment uri if exists
                $tmpUri = $uri . '-' . $i;
            }
            $uri = $tmpUri;

            // update uri if needed
            if ($uri != $model->translate($locale)->uri) {
                // set uri to model
                $model->translate($locale)->uri = $uri;
            }

        }
        $this->updateChildren($model);
    }

    /**
     * Update children
     * 
     * @param  Model $model eloquent
     * @return mixed false or void
     */
    private function updateChildren(Model $model)
    {

        // exit('update children');
        foreach ($model->children as $child) {
            foreach (Config::get('app.locales') as $locale) {
                $child->translate($locale)->uri = $model->translate($locale)->uri . '/' . $child->translate($locale)->slug;
            }
            // print_r($child->translate('fr')->uri);
            $child->save();
        }
    }

    /**
     * Get uris and slugs from all pages
     *
     * @return array
     */
    private function getAllUris()
    {
        // Build uris array of all pages (needed for uris updating after sorting)
        $pages = DB::table('page_translations')
                   ->select('page_id', 'locale', 'uri', 'slug')
                   ->get();
        $urisAndSlugs = array();
        foreach ($pages as $page) {
            $urisAndSlugs[$page->page_id][$page->locale] = array(
                'uri' => $page->uri,
                'slug' => $page->slug
            );
        }
        return $urisAndSlugs;
    }

    /**
     * Get flat array of all uris
     *
     * @return array
     */
    private function flatUris()
    {
        return DB::table('page_translations')->lists('page_id', 'uri');
    }

    /**
     * Check if uri exists in flatUris
     *
     * @param  string $uri
     * @param  int    $id
     * @return bool
     */
    private function uriExists($uri, $id)
    {
        if (array_key_exists($uri, $this->flatUris)) {
            if ($id != $this->flatUris[$uri]) {
                return true;
            }
        }
        return false;
    }
}
