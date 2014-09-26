<?php
namespace TypiCMS\Modules\Blocks\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Blocks\Repositories\BlockInterface;
use TypiCMS\Modules\Blocks\Services\Form\BlockForm;

class AdminController extends AdminSimpleController
{

    public function __construct(BlockInterface $block, BlockForm $blockform)
    {
        parent::__construct($block, $blockform);
        $this->title['parent'] = trans_choice('blocks::global.blocks', 2);
    }
}
