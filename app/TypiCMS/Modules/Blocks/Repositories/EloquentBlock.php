<?php
namespace TypiCMS\Modules\Blocks\Repositories;

use StdClass;

use App;
use Input;
use Config;
use Croppa;
use Request;

use FileUpload;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentBlock extends RepositoriesAbstract implements BlockInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array('translations'), $all = false)
    {
        $query = $this->make($with);

        if (! $all) {
            // take only translated items that are online
            $query->whereHas(
                'translations',
                function ($query) {
                    $query->where('status', 1);
                    $query->where('locale', App::getLocale());
                }
            );
        }

        // Query ORDER BY
        $query = $query->order();

        // Get
        $models = $query->get();

        // Nesting
        if (property_exists($this->model, 'children')) {
            $models->nest();
        }

        return $models;
    }
}
