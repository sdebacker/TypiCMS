<?php
namespace TypiCMS\Repositories;

use StdClass;

use DB;
use Str;
use App;
use Input;
use Config;

use TypiCMS\Services\Helpers;
use TypiCMS\Modules\Pages\Models\Page;

use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;

abstract class RepositoriesAbstract
{
    protected $model;
    protected $gallery;

    public function __construct()
    {
        $this->gallery = App::make('TypiCMS\Modules\Galleries\Repositories\GalleryInterface');
    }

    /**
     * get empty model
     * @return model
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
    public function getFirstBy($key, $value, array $with = array(), $all = false)
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
     * @return stdObject object of model information
     */
    public function byId($id, array $with = array())
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
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
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
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false)
    {
        $query = $this->make($with);

        if (! $all) {
            // take only translated items that are online
            $query = $query->whereHasOnlineTranslation();
        }

        // Query ORDER BY
        $query = $query->order();

        // Get
        $models = $query->get();

        // Nesting
        if (property_exists($this->model, 'children')) {
            $models->nest();
        }

        return $models;
    }

    /**
     * Get all models with categories
     *
     * @param  boolean  $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAllBy($key, $value, array $with = array(), $all = false)
    {
        $query = $this->make($with);

        if (! $all) {
            // Take only online and translated items
            $query = $query->whereHasOnlineTranslation();
        }

        $query->where($key, $value);

        $models = $query->get();

        return $models;
    }

    /**
     * Get latest models
     * 
     * @param  integer      $number number of items to take
     * @param  array        $with array of related items
     * @return Collection
     */
    public function latest($number = 10, array $with = array('translations'))
    {
        $query = $this->make($with);
        return $query->whereHasOnlineTranslation()->order()->take($number)->get();
    }

    /**
     * Get single model by URL
     *
     * @param string  URL slug of model
     * @return object object of model information
     */
    public function bySlug($slug, array $with = array())
    {
        // Find id
        $id = Helpers::getIdFromSlug($this->model->getTable(), $slug);

        $model = $this->make($with)
            ->whereHasOnlineTranslation()
            ->withOnlineGalleries()
            ->findOrFail($id);

        if (! count($model->translations)) {
            App::abort('404');
        }

        return $model;

    }

    /**
     * Return all results that have a required relationship
     *
     * @param string $relation
     */
    public function has($relation, array $with = array())
    {
        $entity = $this->make($with);

        return $entity->has($relation)->get();
    }

    /**
     * Create a new model
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        if ($model = $this->model->create($data)) {
            isset($data['galleries']) and $this->syncGalleries($model, $data['galleries']);
            
            return $model;
        }

        return false;
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
        isset($data['galleries']) and $this->syncGalleries($model, $data['galleries']);

        return true;
    }

    /**
     * Sort models
     *
     * @param array  Data to update Pages
     * @return boolean
     */
    public function sort(array $data)
    {

        if (isset($data['nested']) and $data['nested']) {

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

    public function getPagesForSelect()
    {
        $pagesArray = Page::select('pages.id', 'title', 'locale')
            ->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
            ->where('locale', Config::get('typicms.adminLocale'))
            ->lists('id', 'title');
        $pagesArray = array_merge(array('' => '0'), $pagesArray);
        $pagesArray = array_flip($pagesArray);

        return $pagesArray;
    }

    public function getModulesForSelect()
    {
        $modulesArray = Config::get('modules');
        $selectModules = array('' => '');
        foreach ($modulesArray as $module => $property) {
            if ($property['menu']) {
                $selectModules[strtolower($module)] = Str::title(trans(strtolower($module) . '::global.name'));
            }
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
        if ($model->files) {
            $model->files->each(function ($file) {
                $file->delete();
            });
        }
        if ($model->delete()) {
            return true;
        }

        return false;
    }

    /**
     * Sync tags for model
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  array                               $tags
     * @return void
     */
    protected function syncTags($model, array $tags)
    {
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
     * Sync galleries for model
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  array                               $galleries
     * @return void
     */
    protected function syncGalleries($model, array $galleries)
    {
        // Create or add galleries
        $pivotData = array();
        if ($galleries) {
            $position = 0;
            $found = $this->gallery->findOrForget($galleries);
            foreach ($found as $gallery) {
                $position++;
                $pivotData[$gallery->id] = array('position' => $position);
            }
        }

        // Assign set galleries to model
        $model->galleries()->sync($pivotData);
    }
}
