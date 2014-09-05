<?php
namespace TypiCMS\Modules\Places\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface PlaceInterface extends RepositoryInterface
{

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   Show published or all
     * @return StdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array('translations'), $all = false);

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array('translations'), $all = false);

    /**
     * Get single model by slug
     *
     * @param  string $slug slug of model
     * @return object model
     */
    public function bySlug($slug, array $with = array('translations'));
}
