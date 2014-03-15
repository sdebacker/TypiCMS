<?php namespace TypiCMS\Modules\Places\Repositories;

use StdClass;

use App;
use Input;
use Config;
use Request;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentPlace extends RepositoriesAbstract implements PlaceInterface {

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    /**
     * Get paginated pages
     *
     * @param int $page Number of pages per page
     * @param int $limit Results per page
     * @param boolean $all Show published or all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, $all = false, $relatedModel = null)
    {
        $result = new StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->model
            ->select('places.*', 'status')
            ->with('translations')
            ->join('place_translations', 'place_translations.place_id', '=', 'places.id')
            ->where('locale', App::getLocale())
            ->skip($limit * ($page - 1))
            ->take($limit);

        ! $all and $query->where('status', 1);
        $query->order();
        $models = $query->get();

        // Build query to get totalItems
        $queryTotal = $this->model;
        ! $all and $queryTotal->where('status', 1);

        // Put items and totalItems in StdClass
        $result->totalItems = $queryTotal->count();
        $result->items = $models->all();

        return $result;
    }


    /**
     * Get all models
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll($all = false, $category_id = null)
    {
        // get search string
        $string = Input::get('string');

        $query = $this->model->with('translations');

        if ( ! $all ) {
            // take only translated items that are online
            $query->whereHas('translations', function($query)
                {
                    $query->where('status', 1);
                    $query->where('locale', '=', App::getLocale());
                }
            );
        }

        if (Request::wantsJson()) { // pour affichage sur la carte
            $query->where('latitude', '!=', '');
            $query->where('longitude', '!=', '');
        }

        $string and $query->where('title', 'LIKE', '%'.$string.'%');

        $query->order();

        $models = $query->get();

        return $models;
    }


    /**
     * Get single model by URL
     *
     * @param string  URL slug of model
     * @return object object of model information
     */
    public function bySlug($slug)
    {
        $model = $this->model->with('translations')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return $model;

    }


    /**
     * Create a new model
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        // Create the model
        $model = $this->model;

        $data = array_except($data, array('exit'));

        $model->fill($data);

        if (Input::hasFile('logo')) {
            $model->logo = $this->upload(Input::file('logo'));
        }

        if (Input::hasFile('image')) {
            $model->image = $this->upload(Input::file('image'));
        }

        $model->save();

        if ( ! $model ) {
            return false;
        }

        return $model;
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

        $data = array_except($data, array('exit'));
        $model->fill($data);

        if (Input::hasFile('logo')) {
            // delete prev logo
            Croppa::delete('/uploads/'.$this->model->getTable().'/'.$model->getOriginal('logo'));
            $model->logo = $this->upload(Input::file('logo'));
        } else {
            $model->logo = $model->getOriginal('logo');
        }

        if (Input::hasFile('image')) {
            // delete prev image
            Croppa::delete('/uploads/'.$this->model->table.'/'.$model->getOriginal('image'));
            $model->image = $this->upload(Input::file('image'));
        } else {
            $model->image = $model->getOriginal('image');
        }

        $model->save();

        return true;
        
    }


}