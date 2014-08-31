<?php
namespace TypiCMS\Modules\Places\Repositories;

use StdClass;
use App;
use Input;
use Request;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentPlace extends RepositoriesAbstract implements PlaceInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   Show published or all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array('translations'), $all = false)
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
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return \Illuminate\Database\Eloquent\Collection Object with $items
     */
    public function getAll(array $with = array('translations'), $all = false)
    {
        // get search string
        $string = Input::get('string');

        $query = $this->model->with('translations');

        if (! $all) {
            // take only translated items that are online
            $query->whereHas(
                'translations',
                function ($query) {
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
     * Get single model by slug
     *
     * @param  string $slug slug of model
     * @return object model
     */
    public function bySlug($slug, array $with = array('translations'))
    {
        $model = $this->model->with('translations')
            ->where('slug', $slug)
            ->whereHas(
                'translations',
                function ($query) {
                    if (! Input::get('preview')) {
                        $query->where('status', 1);
                    }
                    $query->where('locale', '=', App::getLocale());
                }
            )
            ->firstOrFail();

        return $model;

    }
}
