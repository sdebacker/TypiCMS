<?php namespace TypiCMS\Modules\Tags\Repositories;

interface TagInterface
{

    /**
     * Get tags paginated
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function byPage($page = 1, $limit = 10, $all = false, $relatedModel = null);

    /**
     * Get all tags
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll($all = false, $relatedModel = null);

    /**
     * Find existing tags or create if they don't exist
     *
     * @param  Array $tags  Array of strings, each representing a tag
     * @return array         Array or Arrayable collection of Tag objects
     */
    public function findOrCreate(array $tags);

}
