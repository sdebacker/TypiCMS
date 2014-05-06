<?php
namespace TypiCMS\Modules\Files\Repositories;

use App;
use Input;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class CacheDecorator extends CacheAbstractDecorator implements FileInterface
{

    // Class expects a repo and a cache interface
    public function __construct(FileInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  model    $from  related model
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @param  string   $type  file type : a,v,d,i,o
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPageFrom($page = 1, $limit = 10, $from = null, array $with = array(), $all = false, $type = null)
    {
        $fromKey = ($from) ? $from->id . get_class($from) : '' ;
        $cacheKey = md5(
            App::getLocale() . 'byPageFrom' . $page . $limit . $fromKey . $all . implode(Input::except('page')) . $type
        );

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->byPageFrom($page, $limit, $from, $with, $all, $type);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;

    }
}
