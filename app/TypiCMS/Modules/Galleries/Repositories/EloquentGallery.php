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
     * Get all items name
     * 
     * @return array with names
     */
    public function getNames()
    {
        return $this->model->lists('name');
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

        foreach ($galleries as $name) {
            $found = $this->model->where('name', $name)->first();
            if ($found) {
                $filteredGalleries[] = $found;
            }
        }

        return $filteredGalleries;
    }
}
