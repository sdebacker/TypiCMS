<?php
namespace TypiCMS\Modules\Places\Repositories;

use App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Input;
use stdClass;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentPlace extends RepositoriesAbstract implements PlaceInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   Show published or all
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
    {
        $result = new stdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->make($with)
            ->select('places.*', 'status', 'title')
            ->join('place_translations', 'place_translations.place_id', '=', 'places.id')
            ->where('locale', App::getLocale())
            ->skip($limit * ($page - 1))
            ->take($limit);

        if (! $all) {
            // take only translated items that are online
            $query->whereHasOnlineTranslation();
        }
        $query->order();
        $models = $query->get();

        // Build query to get totalItems
        $queryTotal = $this->model;
        if (! $all) {
            // take only translated items that are online
            $queryTotal->whereHasOnlineTranslation();
        }

        // Put items and totalItems in stdClass
        $result->totalItems = $queryTotal->count();
        $result->items = $models->all();

        return $result;
    }

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return Collection Object with $items
     */
    public function getAll(array $with = array(), $all = false)
    {
        // get search string
        $string = Input::get('string');

        $query = $this->make($with)
            ->select('places.*', 'status', 'title')
            ->join('place_translations', 'place_translations.place_id', '=', 'places.id')
            ->where('locale', App::getLocale());
        
        if (! $all) {
            // take only translated items that are online
            $query->whereHasOnlineTranslation();
        }

        $string && $query->where('title', 'LIKE', '%'.$string.'%');

        $query->order();

        // Get
        return $query->get();
    }
}
