<?php
namespace TypiCMS\Modules\Categories\Controllers;

use Str;
use View;
use TypiCMS\Controllers\BasePublicController;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface;

class PublicController extends BasePublicController
{

    public function __construct(CategoryInterface $category)
    {
        parent::__construct($category);
        $this->title['parent'] = Str::title(trans_choice('categories::global.categories', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->title['child'] = '';

        $models = $this->repository->getAll(array('translations'));

        $this->layout->content = View::make('categories.public.index')
            ->with('models', $models);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($category = null, $slug = null)
    {
        $model = $this->repository->bySlug($slug);

        $this->title['parent'] = $model->title;

        $this->layout->content = View::make('categories.public.show')
            ->with('model', $model);
    }
}
