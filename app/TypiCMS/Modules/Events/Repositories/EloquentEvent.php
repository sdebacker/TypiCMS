<?php
namespace TypiCMS\Modules\Events\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentEvent extends RepositoriesAbstract implements EventInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get incomings events
     *
     * @param  integer      $number number of items to take
     * @param  array        $with array of related items
     * @return Collection
     */
    public function incoming($number = null, array $with = array('translations'))
    {
        $query = $this->make($with);
        $query->where('end_date', '>=', date('Y-m-d'))
            ->whereHasOnlineTranslation()
            ->orderBy('start_date');
        if ($number) {
            $query->take($number);
        }
        return $query->get();
    }

    /**
     * Create a new model
     *
     * @param  array $data
     * @return mixed Model or false on error during save
     */
    public function create(array $data)
    {
        $data = $this->combineDateTime($data, 'start_');
        $data = $this->combineDateTime($data, 'end_');
        return parent::create($data);
    }

    /**
     * Update an existing model
     *
     * @param  array  $data
     * @return boolean
     */
    public function update(array $data)
    {
        $data = $this->combineDateTime($data, 'start_');
        $data = $this->combineDateTime($data, 'end_');
        return parent::update($data);
    }

    /**
     * Combine date and time
     * 
     * @param  array  $data
     * @param  string $prefix
     * @return array
     */
    private function combineDateTime($data, $prefix = null)
    {
        if (isset($data[$prefix . 'date']) && isset($data[$prefix . 'time']) ) {
            $time = $data[$prefix . 'time'] ? : '00:00' ;
            $date = $data[$prefix . 'date'] ? : '0000-00-00' ;
            $data[$prefix . 'date'] = $date . ' ' . $time . ':00';
            unset($data[$prefix . 'time']);
        }
        return $data;
    }
}
