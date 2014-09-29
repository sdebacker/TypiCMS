<?php
namespace TypiCMS\Modules\Groups\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Groups\Repositories\GroupInterface;
use TypiCMS\Modules\Groups\Services\Form\GroupForm;
use View;

class AdminController extends AdminSimpleController
{

    /**
     * __construct
     *
     * @param GroupInterface $group
     * @param GroupForm     $groupForm
     */
    public function __construct(GroupInterface $group, GroupForm $groupForm)
    {
        parent::__construct($group, $groupForm);
        $this->title['parent'] = trans_choice('groups::global.groups', 2);

        // Establish Filters
        $this->beforeFilter('inGroup:Admins');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($group)
    {
        $this->title['child'] = trans('groups::global.Edit');

        $this->layout->content = View::make('admin.edit')
            ->withPermissions($group->getPermissions())
            ->withModel($group);
    }
}
