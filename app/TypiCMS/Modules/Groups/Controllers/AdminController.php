<?php
namespace TypiCMS\Modules\Groups\Controllers;

use TypiCMS\Controllers\BaseAdminController;
use TypiCMS\Modules\Groups\Repositories\GroupInterface;
use TypiCMS\Modules\Groups\Services\Form\GroupForm;

class AdminController extends BaseAdminController
{

    /**
     * __construct
     *
     * @param GroupInterface $group
     * @param GroupForm      $groupForm
     */
    public function __construct(GroupInterface $group, GroupForm $groupForm)
    {
        parent::__construct($group, $groupForm);
        $this->title['parent'] = trans_choice('groups::global.groups', 2);

        // Establish Filters
        $this->beforeFilter('inGroup:Admins');
    }
}
