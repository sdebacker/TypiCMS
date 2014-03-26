<?php
namespace TypiCMS\Modules\Files\Repositories;

interface FileInterface
{

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  model    $from  related model
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPageFrom($page = 1, $limit = 10, $from, array $with = array(), $all = false);

    /**
     * Delete model
     *
     * @return boolean
     */
    public function delete($model);

    /**
     * Create a new model
     *
     * @param array  Data to create a new model
     * @return boolean
     */
    public function create(array $data);

    /**
     * Update an existing model
     *
     * @param array  Data to update a model
     * @return boolean
     */
    public function update(array $data);

}
