<?php namespace TypiCMS\Modules\Tags\Repositories;

use TypiCMS\Modules\Tags\Repositories\TagInterface;
use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;

use Illuminate\Database\Eloquent\Model;

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