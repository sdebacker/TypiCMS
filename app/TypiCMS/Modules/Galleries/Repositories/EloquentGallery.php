<?php
namespace TypiCMS\Modules\Galleries\Repositories;

use App;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentGallery extends RepositoriesAbstract implements GalleryInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all items’ slug in current language
     * 
     * @return array with id as key and slug as value
     */
    public function getSlugs()
    {
        $galleries = $this->model->with('translations')->get();
        $galleriesArray = array();
        foreach ($galleries as $key => $gallery) {
            $galleriesArray[] = $gallery->slug;
        }
        return $galleriesArray;
    }

    /**
     * Find existing galleries or forget it if they don't exist
     *
     * @param  array $galleries  Array of strings, each representing a tag
     * @return array        Array or Arrayable collection of Tag objects
     */
    public function findOrForget(array $galleries)
    {
        $filteredGalleries = array();

        foreach ($galleries as $slug) {
            $found = $this->model->whereHas(
                'translations',
                function ($query) use ($slug) {
                    $query->where('slug', $slug);
                    $query->where('locale', App::getLocale());
                }
            )->first();

            if ($found) {
                $filteredGalleries[] = $found;
            }
        }

        return $filteredGalleries;
    }
}
