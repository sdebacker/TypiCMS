<?php
namespace TypiCMS\Modules\Pages\Repositories;

use Config;
use DB;
use Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Input;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentPage extends RepositoriesAbstract implements PageInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Update an existing model
     *
     * @param array  Data needed for model update
     * @return boolean
     */
    public function update(array $data)
    {
        $model = $this->model->find($data['id']);

        $model->fill($data);

        $this->syncRelation($model, $data, 'galleries');

        if ($model->save()) {
            Event::fire('page.resetChildrenUri', [$model]);
            return true;
        }

        return false;
    }

    /**
     * Get a page by its uri
     *
     * @param  string                      $uri
     * @return TypiCMS\Modules\Models\Page $model
     */
    public function getFirstByUri($uri)
    {
        $model = $this->make(['translations'])
            ->where('is_home', 0)
            ->whereHas('translations', function (Builder $query) use ($uri) {
                $query->where('uri', $uri);
                if (! Input::get('preview')) {
                    $query->where('status', 1);
                }
            })
            ->withOnlineGalleries()
            ->firstOrFail();
        return $model;
    }

    /**
     * Get submenu for a page
     *
     * @return Collection
     */
    public function getSubMenu($uri, $all = false)
    {
        $rootUriArray = explode('/', $uri);
        $uri = $rootUriArray[0];
        if (Config::get('app.locale_in_url')) {
            if (isset($rootUriArray[1])) {
                $uri .= '/' . $rootUriArray[1];
            }
        }

        $query = $this->model
            ->with('translations')
            ->select('*')
            ->addSelect('pages.id AS id')
            ->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
            ->where('uri', '!=', $uri)
            ->where('uri', 'LIKE', $uri.'%');

        // All posts or only published
        if (! $all) {
            $query->where('status', 1);
        }
        $query->where('locale', Config::get('app.locale'));

        $query->order();

        return $query->get();
    }

    /**
     * Get Pages to build routes
     *
     * @return Collection
     */
    public function getForRoutes()
    {
        return DB::table('pages')
            ->select('pages.id', 'parent_id', 'uri', 'locale')
            ->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
            ->where('uri', '!=', '')
            ->where('is_home', '!=', 1)
            ->where('status', '=', 1)
            ->orderBy('locale')
            ->get();
    }

    /**
     * Get all uris
     *
     * @return array
     */
    public function getAllUris()
    {
        return DB::table('page_translations')->lists('uri', 'id');
    }

    /**
     * Get sort data
     * 
     * @param  integer $position
     * @param  array   $item
     * @return array
     */
    protected function getSortData($position, $item)
    {
        return [
            'position' => $position,
            'parent_id' => $item['parent_id']
        ];
    }

    /**
     * Fire event to reset children’s uri
     * Only applicable on nestable collections
     * 
     * @param  Page    $page
     * @return void|null
     */
    protected function fireResetChildrenUriEvent($page)
    {
        Event::fire('page.resetChildrenUri', [$page]);
    }
}
