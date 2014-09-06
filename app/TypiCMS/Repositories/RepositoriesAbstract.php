<?php
namespace TypiCMS\Repositories;

use DB;
use Str;
use App;
use Input;
use Config;
use StdClass;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Pages\Models\Page;
use TypiCMS;

abstract class RepositoriesAbstract implements RepositoryInterface
{
    protected $model;
    protected $gallery;

    public function __construct()
    {
        $this->gallery = App::make('TypiCMS\Modules\Galleries\Repositories\GalleryInterface');
    }

    /**
     * get empty model
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
     */
    public function make(array $with = array())
    {
        return $this->model->with($with);
    }

    /**
     * Find a single entity by key value
     *
     * @param string $key
     * @param string $value
     * @param array  $with
     */
    public function getFirstBy($key, $value, array $with = array('translations'), $all = false)
    {
        $query = $this->make($with);
        if (! $all) {
            // take only translated items that are online
            $query = $query->whereHasOnlineTranslation();
        }
        return $query->where($key, '=', $value)->first();
    }

    /**
     * Retrieve model by id
     * regardless of status
     *
     * @param  int       $id model ID
     * @return Model
     */
    public function byId($id, array $with = array('translations'))
    {
        $query = $this->make($with)->where('id', $id);

        $model = $query->firstOrFail();

        return $model;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @return StdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array('translations'), $all = false)
    {
        $result = new StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->make($with);

        if (! $all) {
            // take only translated items that are online
            $query = $query->whereHasOnlineTranslation();
        }

        $totalItems = $query->count();

        $query = $query->order()
            ->skip($limit * ($page - 1))
            ->take($limit);

        $models = $query->get();

        // Put items and totalItems in StdClass
        $result->totalItems = $totalItems;
        $result->items = $models->all();

        return $result;
    }

    /**
     * Get all models
     *
     * @param  array       $with Eager load related models
     * @param  boolean     $all  Show published or all
     * @return \Illuminate\Database\Eloquent\Collection|\TypiCMS\NestedCollection
     */
    public function getAll(array $with = array('translations'), $all = false)
    {
        $query = $this->make($with);

        if (! $all) {
            // take only translated items that are online
            $query = $query->whereHasOnlineTranslation();
        }

        // Query ORDER BY
        $query = $query->order();

        // Get
        return $query->get();
    }

    /**
     * Get all models and nest
     *
     * @param  boolean                    $all  Show published or all
     * @param  array                      $with Eager load related models
     * @return \TypiCMS\NestedCollection  with $items
     */
    public function getAllNested(array $with = array('translations'), $all = false)
    {
        // Get
        return $this->getAll($with, $all)->nest();
    }

    /**
     * Get all models with categories
     *
     * @param  boolean                                  $all Show published or all
     * @return \Illuminate\Database\Eloquent\Collection Object with $items
     */
    public function getAllBy($key, $value, array $with = array('translations'), $all = false)
    {
        $query = $this->make($with);

        if (! $all) {
            // Take only online and translated items
            $query = $query->whereHasOnlineTranslation();
        }

        $query->where($key, $value);

        // Query ORDER BY
        $query = $query->order();

        // Get
        $models = $query->get();

        return $models;
    }

    /**
     * Get latest models
     *
     * @param  integer      $number number of items to take
     * @param  array        $with array of related items
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latest($number = 10, array $with = array('translations'))
    {
        $query = $this->make($with);
        return $query->whereHasOnlineTranslation()->order()->take($number)->get();
    }

    /**
     * Get single model by Slug
     *
     * @param  string $slug slug
     * @param  array  $with related tables
     * @return mixed
     */
    public function bySlug($slug, array $with = array('translations'))
    {
        $model = $this->make($with)
            ->whereHas(
                'translations',
                function (Builder $query) use ($slug) {
                    if (! Input::get('preview')) {
                        $query->where('status', 1);
                    }
                    $query->where('locale', App::getLocale());
                    $query->where('slug', '=', $slug);
                }
            )
            ->withOnlineGalleries()
            ->firstOrFail();

        if (! count($model->translations)) {
            App::abort(404);
        }

        return $model;

    }

    /**
     * Return all results that have a required relationship
     *
     * @param string $relation
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function has($relation, array $with = array())
    {
        $entity = $this->make($with);

        return $entity->has($relation)->get();
    }

    /**
     * Create a new model
     *
     * @param array  Data needed for model creation
     * @return mixed Model or false on error during save
     */
    public function create(array $data)
    {
        // Create the model
        $model = $this->model->fill($data);

        if ($model->save()) {
            $this->syncRelation($model, $data, 'galleries');
            return $model;
        }

        return false;
    }

    /**
     * Update an existing model
     *
     * @param array  Data needed for model update
     * @return boolean
     */
    public function update(array $data)
    {
        $model = $this->model->find($data['id']);

        $model->fill($data);

        $this->syncRelation($model, $data, 'galleries');

        if ($model->save()) {
            return true;
        }

        return false;

    }

    /**
     * Sort models
     *
     * @param array  Data to update Pages
     * @return boolean
     */
    public function sort(array $data)
    {

        if (isset($data['nested']) && $data['nested']) {

            $position = 0;

            foreach ($data['item'] as $id => $parent) {

                $position ++;

                $parent = $parent ? : 0 ;

                DB::table($this->model->getTable())
                  ->where('id', $id)
                  ->update(array('position' => $position, 'parent' => $parent));

            }

        } else {

            foreach ($data['item'] as $key => $id) {

                $position = $key + 1;

                $this->model->find($id)
                    ->update(array('position' => $position));

            }

        }

        return true;

    }

    /**
     * Build a select menu for a module
     *
     * @param  string  $method     with method to call from the repository ?
     * @param  boolean $firstEmpty generate an empty item
     * @param  string  $value      witch field as value ?
     * @param  string  $key        witch field as key ?
     * @return array               array with key = $key and value = $value
     */
    public function select($method = 'getAll', $firstEmpty = false, $value = 'title', $key = 'id')
    {
        $items = $this->$method()->lists($value, $key);
        if ($firstEmpty) {
            $items = ['' => ''] + $items;
        }
        return $items;
    }

    /**
     * Get all translated pages for a select/options
     *
     * @return array
     */
    public function getPagesForSelect()
    {
        $pages = Page::select('pages.id', 'title', 'locale', 'parent')
            ->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
            ->where('locale', Config::get('typicms.adminLocale'))
            ->order()
            ->get();

        $pagesArray = TypiCMS::arrayIndent($pages);

        $pagesArray = array_merge(['' => '0'], $pagesArray);
        $pagesArray = array_flip($pagesArray);

        return $pagesArray;
    }

    /**
     * Get all modules for a select/options
     *
     * @return array
     */
    public function getModulesForSelect()
    {
        $modulesArray = Config::get('modules');
        $selectModules = array('' => '');
        foreach ($modulesArray as $module) {
            $selectModules[strtolower($module)] = Str::title(trans(strtolower($module) . '::global.name'));
        }

        return $selectModules;
    }

    /**
     * Delete model
     *
     * @return boolean
     */
    public function delete($model)
    {
        if ($model->delete()) {
            return true;
        }

        return false;
    }

    /**
     * Sync tags for model
     *
     * @param  Model $model
     * @param  array                               $tags
     * @return false|null false or void
     */
    protected function syncTags($model, array $tags)
    {
        if (! method_exists($model, 'tags')) {
            return false;
        }

        // Create or add tags
        $tagIds = array();

        if ($tags) {
            $found = $this->tag->findOrCreate($tags);
            foreach ($found as $tag) {
                $tagIds[] = $tag->id;
            }
        }

        // Assign set tags to model
        $model->tags()->sync($tagIds);
    }

    /**
     * Sync related items for model
     *
     * @param  Model $model
     * @param  array                               $data
     * @param  string                              $table
     * @return false|null
     */
    protected function syncRelation($model, array $data, $table = null)
    {
        if (! method_exists($model, $table)) {
            return false;
        }

        if (! isset($data[$table])) {
            return false;
        }

        // add related items
        $pivotData = array();
        $position = 0;
        foreach ($data[$table] as $id) {
            $pivotData[$id] = ['position' => $position++];
        }

        // Sync related items
        $model->$table()->sync($pivotData);
    }
}
