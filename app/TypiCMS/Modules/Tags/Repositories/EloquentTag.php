<?php namespace TypiCMS\Modules\Tags\Repositories;

use DB;
use App;
use Request;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Modules\Tags\Repositories\TagInterface;
use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;

class EloquentTag extends RepositoriesAbstract implements TagInterface {

	protected $tag;
	protected $cache;

	// Class expects an Eloquent model
	public function __construct(Model $tag, CacheInterface $cache)
	{
		$this->tag = $tag;
		$this->cache = $cache;
	}


	/**
	 * Get tags paginated
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function byPage($paginationPage = 1, $limit = 10, $all = false, $relatedModel = null)
	{
		$query = $this->tag->select(
				'*',
				DB::raw("(SELECT COUNT(*) FROM `typi_projects_tags` WHERE `tag_id` = `typi_tags`.`id`) AS 'count'")
			)
			->with('projects')
			->orderBy('count', 'desc');

		$models = $query->paginate($limit);

		return $models;
	}


	/**
	 * Get all tags
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $relatedModel = null)
	{
		// Build our cache item key, unique per model number,
		// limit and if we're showing all
		$allkey = ($all) ? '.all' : '';
		$key = md5(App::getLocale().'all'.$allkey);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it

		$query = $this->tag;

		$models = $query->lists('tag');

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
		$foundTags = $this->tag->whereIn('tag', $tags)->get();

		$returnTags = array();

		if( $foundTags ) {
			foreach( $foundTags as $tag ) {
				$pos = array_search($tag->tag, $tags);

				// Add returned tags to array if( $pos !== false )
				{
					$returnTags[] = $tag;
					unset($tags[$pos]);
				}
			}
		}

		// Add remainings tags as new
		foreach( $tags as $tag ) {
			$returnTags[] = $this->tag->create(array(
				'tag' => $tag,
				'slug' => $this->slug($tag),
			));
		}

		return $returnTags;
	}

}