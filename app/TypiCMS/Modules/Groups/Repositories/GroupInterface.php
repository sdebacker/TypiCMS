<?php
namespace TypiCMS\Modules\Groups\Repositories;

use Cartalyst\Sentry\Groups\GroupInterface as Model;
use TypiCMS\Repositories\RepositoryInterface;

interface GroupInterface extends RepositoryInterface
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Model|boolean false on error
     */
    public function create(array $data);

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @return boolean
     */
    public function update(array $id);

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return boolean
     */
    public function destroy($id);

    /**
     * Return a specific group by a given id
     *
     * @param  integer $id
     * @return Model|null null on group not found
     */
    public function byId($id, array $with = array());

    /**
     * Return a specific group by a given name
     *
     * @param  string $name
     * @return Model|null null on group not found
     */
    public function byName($name);

    /**
     * Get all models
     *
     * @param  boolean    $all  Show published or all
     * @param  array      $with Eager load related models
     * @return Collection Object with $items
     */
    public function getAll(array $with = array(), $all = false);
}
