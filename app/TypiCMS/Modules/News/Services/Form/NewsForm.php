<?php
namespace TypiCMS\Modules\News\Services\Form;

use TypiCMS\Services\Form\AbstractForm;
use TypiCMS\Services\Validation\ValidableInterface;
use TypiCMS\Modules\News\Repositories\NewsInterface;

class NewsForm extends AbstractForm
{

    public function __construct(ValidableInterface $validator, NewsInterface $news)
    {
        $this->validator = $validator;
        $this->repository = $news;
    }
}
