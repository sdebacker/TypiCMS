<?php
namespace TypiCMS\Modules\Groups\Repositories;

use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\UserExistsException;
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
     * @return model
     */
    public function getModel()
    {
        return $this->sentry->getGroupProvider()->createModel();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
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
        } catch (LoginRequiredException $e) {
        } catch (UserExistsException $e) {
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
     * @return Group
     */
    public function byId($id, array $with = array())
    {
        try {
            $group = $this->sentry->findGroupById($id);
        } catch (GroupNotFoundException $e) {
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
        } catch (GroupNotFoundException $e) {
            return false;
        }

        return $group;
    }

    /**
     * Return all the registered groups
     *
     * @return Collection Collection of groups
     */
    public function all()
    {
        return Collection::make($this->sentry->getGroupProvider()->findAll());
    }
}
