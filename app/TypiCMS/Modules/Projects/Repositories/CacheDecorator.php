<?php
namespace TypiCMS\Modules\Projects\Repositories;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements ProjectInterface
{

    // Class expects a repo and a cache interface
    public function __construct(ProjectInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Create a new model
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        $model = $this->repo->create($data);
        $this->cache->flush('Projects', 'Dashboard', 'Tags');

        return $model;
    }

    /**
     * Update an existing model
     *
     * @param array  Data to update a model
     * @return boolean
     */
    public function update(array $data)
    {
        $bool = $this->repo->update($data);
        $this->cache->flush('Projects', 'Tags');

        return $bool;
    }
}
