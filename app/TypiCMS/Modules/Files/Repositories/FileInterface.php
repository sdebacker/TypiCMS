<?php
namespace TypiCMS\Modules\Files\Repositories;

use stdClass;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoryInterface;

interface FileInterface extends RepositoryInterface
{

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  model    $gallery_id  related model
     * @param  array    $with  Eager load related models
     * @param  boolean  $all   get published models or all
     * @param  string   $type  file type : a,v,d,i,o
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPageFrom(
        $page = 1,
        $limit = 10,
        $gallery_id = null,
        array $with = array(),
        $all = false,
        $type = null
    );
}
