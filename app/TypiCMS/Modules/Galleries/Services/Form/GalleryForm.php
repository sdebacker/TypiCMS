<?php
namespace TypiCMS\Modules\Galleries\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;

class GalleryForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, GalleryInterface $gallery)
    {
        $this->validator = $validator;
        $this->repository = $gallery;
    }
}
