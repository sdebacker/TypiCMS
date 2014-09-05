<?php
namespace TypiCMS\Modules\Tags\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface TagInterface extends RepositoryInterface
{

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @return StdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false);

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false);

    /**
     * Find existing tags or create if they don't exist
     *
     * @param  Array $tags Array of strings, each representing a tag
     * @return array Array or Arrayable collection of Tag objects
     */
    public function findOrCreate(array $tags);
}
