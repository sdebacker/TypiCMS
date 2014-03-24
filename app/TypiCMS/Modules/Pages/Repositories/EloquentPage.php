<?php
namespace TypiCMS\Modules\Pages\Repositories;

use DB;
use App;
use Config;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Services\ListBuilder;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentPage extends RepositoriesAbstract implements PageInterface
{

    protected $urisAndSlugs = array();
    protected $flatUris = array();

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Update an existing model
     *
     * @param array  Data to update a model
     * @return boolean
     */
    public function update(array $data)
    {

        $model = $this->model->find($data['id']);
        $model->fill($data);
        $model->save();

        $this->urisAndSlugs = $this->getAllUris();
        $this->flatUris = $this->flatUris();

        // update URI in all pages
        $pages = $this->model->order()->get();
        foreach ($pages as $key => $page) {
            $this->updateUris($page->id, $page->parent);
        }

        return true;

    }

    /**
     * Get uris and slugs from all pages
     *
     * @return Array[id][lang] = array('uri' => $uri, 'slug' => $slug)
     */
    public function getAllUris()
    {
        // Build uris array of all pages (needed for uris updating after sorting)
        $pages = DB::table('page_translations')
                   ->select('page_id', 'locale', 'uri', 'slug')
                   ->get();
        // var_dump($pages);
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
     * Get page by uri
     *
     * @param  string                      $uri
     * @return TypiCMS\Modules\Models\Page $model
     */
    public function byUri($uri)
    {
        $model = $this->model
            ->whereHas('translations', function($q) use ($uri)
            {
                $q->where('uri', $uri);
                $q->where('status', 1);
            })->firstOrFail();
        return $model;
    }

    /**
     * Retrieve children pages
     *
     * @param  int        $id model ID
     * @return Collection
     */
    public function getChildren($uri, $all = false)
    {
        $rootUriArray = explode('/', $uri);
        $uri = $rootUriArray[0].'/'.$rootUriArray[1];

        $query = $this->model
            ->with('translations')
            ->select(
                array(
                    'pages.id AS id',
                    'slug',
                    'uri',
                    'title',
                    'status',
                    'position',
                    'parent'
                )
            )
            ->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
            ->where('uri', '!=', $uri)
            ->where('uri', 'LIKE', $uri.'%');

        // All posts or only published
        if ( ! $all) {
            $query->where('status', 1);
        }
        $query->where('locale', Config::get('app.locale'));

        $query->order();

        $models = $query->get();

        $models->nest();

        return $models;
    }

    /**
     * Build html list
     *
     * @param array
     * @return string
     */
    public function buildSideList($models)
    {
        $listObject = new ListBuilder($models);

        return $listObject->sideList();
    }

    /**
     * Get Pages to build routes
     *
     * @return Collection
     */
    public function getForRoutes()
    {
        return DB::table('pages')
            ->select('pages.id', 'page_id', 'uri', 'locale')
            ->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
            ->where('uri', '!=', '')
            ->where('is_home', '!=', 1)
            ->where('status', '=', 1)
            ->orderBy('locale')
            ->get();
    }

    /**
     * Sort models
     *
     * @param array  Data to update Pages
     * @return boolean
     */
    public function sort(array $data)
    {

        $position = 0;

        $this->urisAndSlugs = $this->getAllUris();
        $this->flatUris = $this->flatUris();

        foreach ($data['item'] as $id => $parent) {

            $position ++;

            $parent = $parent ? : 0 ;

            DB::table('pages')
              ->where('id', $id)
              ->update(array('position' => $position, 'parent' => $parent));

            $this->updateUris($id, $parent);

        }

        return true;

    }

    /**
     * Update pages uris
     *
     * @param  int $id
     * @param  int $parent
     * @return void
     */
    public function updateUris($id, $parent = null)
    {

        // transform URI
        foreach (Config::get('app.locales') as $locale) {

            if (isset($this->urisAndSlugs[$id][$locale]['slug'])) {

                if ($this->urisAndSlugs[$id][$locale]['slug']) {

                    $uri = isset($this->urisAndSlugs[$parent][$locale]['uri']) ? $this->urisAndSlugs[$parent][$locale]['uri'].'/'.$this->urisAndSlugs[$id][$locale]['slug'] : $locale.'/'.$this->urisAndSlugs[$id][$locale]['slug'] ;

                    // Check uri is unique
                    $tmpUri = $uri;
                    $i = 0;
                    while ($this->uriExists($tmpUri, $id)) {
                        $i ++;
                        // increment uri if exists
                        $tmpUri = $uri . '-' . $i;
                    }
                    $uri = $tmpUri;
                } else {
                    $uri = null;
                }

                // update uri if needed
                if ($uri != $this->urisAndSlugs[$id][$locale]['uri']) {
                    // update uri in DB
                    DB::table('page_translations')
                      ->where('page_id', '=', $id)
                      ->where('locale', '=', $locale)
                      ->update(array('uri' => $uri));
                    // update uri in array
                    $this->urisAndSlugs[$id][$locale]['uri'] = $uri;
                }

            }

        }
    }

    /**
     * Get flat array of all uris
     *
     * @return array
     */
    public function flatUris()
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
    public function uriExists($uri, $id)
    {
        if (array_key_exists($uri, $this->flatUris)) {
            if ($id != $this->flatUris[$uri]) {
                return true;
            }
        }
        return false;
    }

}
