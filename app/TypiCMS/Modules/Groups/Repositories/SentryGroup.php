<?php
namespace TypiCMS\Modules\Groups\Repositories;

use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupInterface as Model;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Cartalyst\Sentry\Sentry;
use Illuminate\Support\Collection;
use Input;
use TypiCMS\Repositories\RepositoriesAbstract;

class SentryGroup extends RepositoriesAbstract implements GroupInterface
{

    protected $sentry;

    /**
     * Construct a new SentryGroup Object
     */
    public function __construct(Sentry $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * get empty model
     * 
     * @return Model
     */
    public function getModel()
    {
        return $this->sentry->getGroupProvider()->createModel();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Model|boolean false on error
     */
    public function create(array $data)
    {

        try {
            // Create the group
            $model = $this->sentry->createGroup(array(
                'name'        => e($data['name']),
                'permissions' => $data['permissions'],
            ));
            return $model;
        } catch (NameRequiredException $e) {
        } catch (GroupExistsException $e) {
        }

        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return boolean
     */
    public function update(array $data)
    {

        try {
            // Find the group using the group id
            $group = $this->sentry->findGroupById($data['id']);

            // Update the group details
            $group->name = e($data['name']);
            $group->permissions = Input::get('permissions');

            // Update the group
            $group->save();
            return true;
        } catch (NameRequiredException $e) {
        } catch (GroupExistsException $e) {
        } catch (GroupNotFoundException $e) {
        }
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return boolean
     */
    public function destroy($id)
    {
        try {
            // Find the group using the group id
            $group = $this->sentry->findGroupById($id);

            // Delete the group
            $group->delete();
        } catch (GroupNotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Return a specific group by a given id
     *
     * @param  integer $id
     * @return Model|null null on group not found
     */
    public function byId($id, array $with = array())
    {
        try {
            $group = $this->sentry->findGroupById($id);
        } catch (GroupNotFoundException $e) {
            return null;
        }

        return $group;
    }

    /**
     * Return a specific group by a given name
     *
     * @param  string $name
     * @return Model|null null on group not found
     */
    public function byName($name)
    {
        try {
            $group = $this->sentry->findGroupByName($name);
        } catch (GroupNotFoundException $e) {
            return null;
        }

        return $group;
    }

    /**
     * Get all models
     *
     * @param  boolean    $all  Show published or all
     * @param  array      $with Eager load related models
     * @return Collection Object with $items
     */
    public function getAll(array $with = array(), $all = false)
    {
        return Collection::make($this->sentry->getGroupProvider()->findAll());
    }
}
