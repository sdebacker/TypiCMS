<?php
namespace TypiCMS\Modules\Galleries\Controllers;

use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;
use TypiCMS\Modules\Galleries\Services\Form\GalleryForm;
use TypiCMS\Controllers\AdminSimpleController;

class AdminController extends AdminSimpleController
{

    public function __construct(GalleryInterface $gallery, GalleryForm $galleryform)
    {
        parent::__construct($gallery, $galleryform);
        $this->title['parent'] = trans_choice('galleries::global.galleries', 2);
    }
}
