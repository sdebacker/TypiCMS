<?php
namespace TypiCMS\Modules\Groups\Repositories;

use Input;

use Illuminate\Support\Collection;

use Cartalyst\Sentry\Sentry;
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
     * @return model
     */
    public function getModel()
    {
        return $this->sentry->getModel();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function create(array $data)
    {

        $errors = array();
        try {
            // Create the group
            $model = $this->sentry->createGroup(array(
                'name'        => e($data['name']),
                'permissions' => $data['permissions'],
            ));
            return $model;
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
        }

        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @return Response
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
        } catch (\Cartalyst\Sentry\Groups\NameRequiredException $e) {
        } catch (\Cartalyst\Sentry\Groups\GroupExistsException $e) {
        } catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
        }
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            // Find the group using the group id
            $group = $this->sentry->findGroupById($id);

            // Delete the group
            $group->delete();
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Return a specific group by a given id
     *
     * @param  integer $id
     * @return Group
     */
    public function byId($id, array $with = array())
    {
        try {
            $group = $this->sentry->findGroupById($id);
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            return false;
        }

        return $group;
    }

    /**
     * Return a specific group by a given name
     *
     * @param  string $name
     * @return Group
     */
    public function byName($name)
    {
        try {
            $group = $this->sentry->findGroupByName($name);
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            return false;
        }

        return $group;
    }

    /**
     * Return all the registered groups
     *
     * @return stdObject Collection of groups
     */
    public function all()
    {
        return Collection::make($this->sentry->getGroupProvider()->findAll());
    }
}
