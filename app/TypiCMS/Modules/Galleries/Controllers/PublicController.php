<?php
namespace TypiCMS\Modules\Galleries\Controllers;

use Str;
use View;
use Input;
use Config;
use Paginator;
use TypiCMS;
use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;
use TypiCMS\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    public function __construct(GalleryInterface $gallery)
    {
        parent::__construct($gallery);
        $this->title['parent'] = Str::title(trans_choice('galleries::global.galleries', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        TypiCMS::setModel($this->repository->getModel());

        $page = Input::get('page');
        $itemsPerPage = Config::get('galleries::public.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations'));

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('galleries.public.index')->withModels($models);
    }

    /**
     * Show gallery.
     *
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug, ['translations', 'files', 'files.translations']);

        TypiCMS::setModel($model);

        $this->title['parent'] = $model->title;

        $this->layout->content = View::make('galleries.public.show')
            ->withModel($model);
    }
}
