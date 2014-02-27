<?php namespace TypiCMS\Modules\Projects\Repositories;

use App;
use Config;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Tags\Repositories\TagInterface;

class EloquentProject extends RepositoriesAbstract implements ProjectInterface {

    protected $tag;

	// Class expects an Eloquent model and a TagInterface
	public function __construct(Model $model, TagInterface $tag)
	{
		$this->model = $model;
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
		$query = $this->model->with('translations');

		if ( ! $all ) {
			// Take only online and translated items
			$query->whereHasOnlineTranslation();
		}

		$query->with('category')->with('category.translations');

		$relid and $query->where('category_id', $relid);
		
		// Files
		$this->model->files and $query->files();

		$models = $query->get();

		// Sorting
		$desc = ($this->model->direction == 'desc') ? true : false ;
		$models = $models->sortBy(function($model)
		{
			return $model->{$this->model->order};
		}, null, $desc);

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
        if ( ! $tags) return;

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