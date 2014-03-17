<?php namespace TypiCMS\Modules\Tags\Repositories;

use App;
use Input;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements TagInterface
{

    // Class expects a repo and a cache interface
    public function __construct(TagInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }


    /**
     * Get paginated pages
     *
     * @param int $page Number of pages per page
     * @param int $limit Results per page
     * @param boolean $all Show published or all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
    {
        $key = md5(App::getLocale().'byPage.'.$page.$limit.$all.implode(Input::except('page')));

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        $models = $this->repo->byPage($page, $limit, $with, $all);

        // Store in cache for next request
        $this->cache->put($key, $models);

        return $models;
    }


    /**
     * Get all tags
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false)
    {
        $key = md5(App::getLocale().'all'.$all);

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        $models = $this->repo->getAll($with, $all);

        // Store in cache for next request
        $this->cache->put($key, $models);

        return $models;
    }


    /**
     * Find existing tags or create if they don't exist
     *
     * @param  array $tags  Array of strings, each representing a tag
     * @return array        Array or Arrayable collection of Tag objects
     */
    public function findOrCreate(array $tags)
    {
        $array = $this->repo->findOrCreate($tags);
        $this->cache->flush();
        return $array;
    }

}