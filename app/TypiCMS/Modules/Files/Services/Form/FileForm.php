<?php
namespace TypiCMS\Modules\Files\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\Files\Repositories\FileInterface;

class FileForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, FileInterface $file)
    {
        $this->validator = $validator;
        $this->repository = $file;
    }
}
