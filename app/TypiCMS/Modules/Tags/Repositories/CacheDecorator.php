<?php
namespace TypiCMS\Modules\Tags\Repositories;

use App;
use Input;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements TagInterface
{

    public function __construct(TagInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get paginated pages
     *
     * @param  int      $page  Number of pages per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   Show published or all
     * @return StdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
    {
        $cacheKey = md5(App::getLocale().'byPage.'.$page.$limit.$all.implode('.', Input::except('page')));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->byPage($page, $limit, $with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get all tags
     *
     * @param  boolean  $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false)
    {
        $cacheKey = md5(App::getLocale() . 'all' . implode('.', $with) . $all);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getAll($with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Find existing tags or create if they don't exist
     *
     * @param  array $tags Array of strings, each representing a tag
     * @return array Array or Arrayable collection of Tag objects
     */
    public function findOrCreate(array $tags)
    {
        $this->cache->flush();
        return $this->repo->findOrCreate($tags);
    }
}
