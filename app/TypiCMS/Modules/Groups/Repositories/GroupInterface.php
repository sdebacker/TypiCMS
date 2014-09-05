<?php
namespace TypiCMS\Modules\Groups\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface GroupInterface extends RepositoryInterface
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
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
     * Return a specific user by a given id
     *
     * @param  integer $id
     * @return User
     */
    public function byId($id, array $with = array());

    /**
     * Return a specific user by a given name
     *
     * @param  string $name
     * @return User
     */
    public function byName($name);

    /**
     * Return all the registered users
     *
     * @return \Illuminate\Support\Collection Collection of users
     */
    public function all();
}
