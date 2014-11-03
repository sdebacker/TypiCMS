<?php
namespace TypiCMS\Modules\History\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentHistory extends RepositoriesAbstract implements HistoryInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models
     *
     * @param  array       $with Eager load related models
     * @param  boolean     $all  Show published or all
     * @return Collection|NestedCollection
     */
    public function getAll(array $with = array(), $all = false)
    {
        $query = $this->make($with);

        // Query ORDER BY
        $query->order();

        // Get
        return $query->get();
    }

    /**
     * Get latest models
     *
     * @param  integer      $number number of items to take
     * @param  array        $with array of related items
     * @return Collection
     */
    public function latest($number = 10, array $with = array())
    {
        $query = $this->make($with);
        return $query->order()->take($number)->get();
    }
}
