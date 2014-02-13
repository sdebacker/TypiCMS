<?php namespace TypiCMS\Modules\Projects\Repositories;

use Config;
use App;
use Request;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Tags\Repositories\TagInterface;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentProject extends RepositoriesAbstract implements ProjectInterface {

    protected $tag;

	// Class expects an Eloquent model, a cache interface and a TagInterface
	public function __construct(Model $model, CacheInterface $cache, TagInterface $tag)
	{
		$this->model = $model;
		$this->cache = $cache;
		$this->tag = $tag;
	}


	/**
	 * Get all models with categories
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $relid = null)
	{
		// Build our cache item key, unique per model number,
		// limit and if we're showing all
		$allkey = ($all) ? '.all' : '';
		$key = md5(App::getLocale().'all'.$allkey);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$query = $this->model->with('translations');

		if ( ! $all ) {
			// Take only translated items that are online
			$query->whereHas('translations', function($query)
				{
					$query->where('status', 1);
					$query->where('locale', '=', App::getLocale());
					$query->where('slug', '!=', '');
				}
			);
		}

		$query->with('category')->with('category.translations');

		$relid and $query->where('category_id', $relid);
		
		// Files
		$this->model->files and $query->with('files');

		$models = $query->get();

		// Sorting
		$desc = ($this->model->direction == 'desc') ? true : false ;
		$models = $models->sortBy(function($model)
		{
			return $model->{$this->model->order};
		}, null, $desc);

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}


	/**
	 * Create a new model
	 *
	 * @param array  Data to create a new object
	 * @return boolean
	 */
	public function create(array $data)
	{
		if ( $model = $this->model->create($data) ) {
			$this->syncTags($model, $data['tags']);
			return $model;
		}
		return false;
	}


	/**
	 * Update an existing model
	 *
	 * @param array  Data to update a model
	 * @return boolean
	 */
	public function update(array $data)
	{
		$model = $this->model->find($data['id']);
		$model->fill($data);
		$model->save();
		$this->syncTags($model, $data['tags']);
		return true;
	}

    /**
     * Sync tags for project
     *
     * @param \Illuminate\Database\Eloquent\Model  $project
     * @param array  $tags
     * @return void
     */
    protected function syncTags(Model $project, array $tags)
    {
        // Create or add tags
        $found = $this->tag->findOrCreate( $tags );

        $tagIds = array();

        foreach($found as $tag) {
            $tagIds[] = $tag->id;
        }

        // Assign set tags to project
        $project->tags()->sync($tagIds);
    }


}