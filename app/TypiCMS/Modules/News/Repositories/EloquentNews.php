<?php
namespace TypiCMS\Modules\News\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentNews extends RepositoriesAbstract implements NewsInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new model
     *
     * @param  array $data
     * @return mixed Model or false on error during save
     */
    public function create(array $data)
    {
        $data = $this->combineDateTime($data);
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
        $data = $this->combineDateTime($data);
        return parent::update($data);
    }

    /**
     * Combine date and time
     * 
     * @param  array $data
     * @return array
     */
    private function combineDateTime($data)
    {
        if (isset($data['date']) && isset($data['time'])) {
            $data['date'] .= ' ' . $data['time'] . ':00';
            unset($data['time']);
        }
        return $data;
    }
}
