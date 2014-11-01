<?php
namespace TypiCMS\Modules\Translations\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Translations\Repositories\TranslationInterface;
use TypiCMS\Modules\Translations\Services\Form\TranslationForm;

class AdminController extends AdminSimpleController
{

    public function __construct(TranslationInterface $translation, TranslationForm $translationform)
    {
        parent::__construct($translation, $translationform);
        $this->title['parent'] = trans_choice('translations::global.translations', 2);
    }
}
