<?php
namespace TypiCMS\Modules\Blocks\Controllers;

use Str;
use View;
use TypiCMS;
use TypiCMS\Modules\Blocks\Repositories\BlockInterface;
use TypiCMS\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    public function __construct(BlockInterface $block)
    {
        parent::__construct($block);
        $this->title['parent'] = Str::title(trans_choice('blocks::global.blocks', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        TypiCMS::setModel($this->repository->getModel());

        $this->title['child'] = '';

        $blocks = $this->repository->getAll();

        $this->layout->content = View::make('blocks.public.index')
            ->withBlocks($blocks);
    }

    /**
     * Show news.
     *
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        TypiCMS::setModel($model);

        $this->title['parent'] = $model->title;

        $this->layout->content = View::make('blocks.public.show')
            ->withModel($model);
    }
}
