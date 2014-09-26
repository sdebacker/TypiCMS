<?php
namespace TypiCMS\Modules\Places\Controllers;

use TypiCMS\Modules\Places\Repositories\PlaceInterface;
use TypiCMS\Modules\Places\Services\Form\PlaceForm;
use TypiCMS\Controllers\AdminSimpleController;

class AdminController extends AdminSimpleController
{

    public function __construct(PlaceInterface $place, PlaceForm $placeform)
    {
        parent::__construct($place, $placeform);
        $this->title['parent'] = trans_choice('places::global.places', 2);
    }
}
