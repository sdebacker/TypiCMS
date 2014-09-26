<?php
namespace TypiCMS\Modules\Partners\Controllers;

use TypiCMS\Modules\Partners\Repositories\PartnerInterface;
use TypiCMS\Modules\Partners\Services\Form\PartnerForm;
use TypiCMS\Controllers\AdminSimpleController;

class AdminController extends AdminSimpleController
{

    public function __construct(PartnerInterface $partner, PartnerForm $partnerform)
    {
        parent::__construct($partner, $partnerform);
        $this->title['parent'] = trans_choice('partners::global.partners', 2);
    }
}
