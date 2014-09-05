<?php
namespace TypiCMS\Modules\Pages\Repositories;

use DB;
use Input;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentPage extends RepositoriesAbstract implements PageInterface
{

    protected $urisAndSlugs = array();
    protected $flatUris = array();

    public function __construct(Model $model)
    {
        parent::__construct();
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

        $this->syncRelation($model, $data, 'galleries');

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
     * Get a page by its uri
     *
     * @param  string                      $uri
     * @return TypiCMS\Modules\Models\Page $model
     */
    public function getFirstByUri($uri)
    {
        $model = $this->make(['translations'])
            ->where('is_home', 0)
            ->whereHas('translations', function (Builder $query) use ($uri) {
                $query->where('uri', $uri);
                if (! Input::get('preview')) {
                    $query->where('status', 1);
                }
            })
            ->withOnlineGalleries()
            ->firstOrFail();
        return $model;
    }

    /**
     * Retrieve children pages
     *
     * @return Collection
     */
    public function getChildren($uri, $all = false)
    {
        $rootUriArray = explode('/', $uri);
        $uri = $rootUriArray[0];
        if (isset($rootUriArray[1])) {
            $uri .= '/' . $rootUriArray[1];
        }

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
        if (! $all) {
            $query->where('status', 1);
        }
        $query->where('locale', Config::get('app.locale'));

        $query->order();

        $models = $query->get();

        $models->nest();

        return $models;
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

                    if (isset($this->urisAndSlugs[$parent][$locale]['uri'])) {
                        $uri = $this->urisAndSlugs[$parent][$locale]['uri'] .
                            '/' .
                            $this->urisAndSlugs[$id][$locale]['slug'];
                    } else {
                        $uri = $this->urisAndSlugs[$id][$locale]['slug'];
                        if (Config::get('app.locale_in_url')) {
                            $uri = $locale . '/' . $uri;
                        }
                    }

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
