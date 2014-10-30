<?php
namespace TypiCMS\Modules\Tags\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Tags\Repositories\TagInterface;
use TypiCMS\Modules\Tags\Services\Form\TagForm;

class AdminController extends AdminSimpleController
{

    public function __construct(TagInterface $tag, TagForm $tagform)
    {
        parent::__construct($tag, $tagform);
        $this->title['parent'] = trans_choice('tags::global.tags', 2);
    }
}
