<?php namespace TypiCMS\Repositories;

use StdClass;

use DB;
use Str;
use App;
use Input;
use Config;

use TypiCMS\Services\Helpers;
use TypiCMS\Modules\Pages\Models\Page;

abstract class RepositoriesAbstract {

	protected $model;

	public function route()
	{
		return $this->model->route;
	}

	public function getModel()
	{
		return $this->model;
	}

	/**
	 * Retrieve model by id
	 * regardless of status
	 *
	 * @param  int $id model ID
	 * @return stdObject object of model information
	 */
	public function byId($id)
	{
		$query = $this->model
			->with('translations')
			->where('id', $id);

		// files
		$this->model->files and $query->files();

		$model = $query->firstOrFail();

		return $model;
	}


	/**
	 * Get paginated pages
	 *
	 * @param int $page Number of pages per page
	 * @param int $limit Results per page
	 * @param boolean $all Show published or all
	 * @return StdClass Object with $items and $totalItems for pagination
	 */
	public function byPage($page = 1, $limit = 10, $all = false, $relatedModel = null)
	{
		$result = new StdClass;
		$result->page = $page;
		$result->limit = $limit;
		$result->totalItems = 0;
		$result->items = array();

		// All posts or only published
		$translations = 'translations';
		if ( ! $all ) {
			$translations = array('translations' => function($query)
			{
				$query->where('status', 1);
			});
		}

		$query = $this->model->with($translations);

		if ($relatedModel) {
			$query->where('fileable_id', $relatedModel->id);
			$query->where('fileable_type', get_class($relatedModel));
		}

		// files
		$this->model->files and $query->files();

		$query->order()
			->skip($limit * ($page - 1))
			->take($limit);
		$models = $query->get();

		// Build query to get totalItems
		$queryTotal = $this->model;
		! $all and $queryTotal->where('status', 1);

		// Put items and totalItems in StdClass
		$result->totalItems = $queryTotal->count();
		$result->items = $models->all();

		return $result;
	}


	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $relatedModel = null)
	{
		$query = $this->model->with('translations');

		if ( ! $all ) {
			// take only translated items that are online
			$query->whereHas('translations', function($query)
				{
					$query->where('status', 1);
					$query->where('locale', '=', App::getLocale());
					$query->where('slug', '!=', '');
				}
			);
		}

		if ($relatedModel) {
			$query->where('fileable_id', $relatedModel->id);
			$query->where('fileable_type', get_class($relatedModel));
		}

		// Files
		$this->model->files and $query = $query->files();

		// Query ORDER BY
		$query->order();

		// Get
		$models = $query->get();

		// Nesting
		if (property_exists($this->model, 'children')) {
			$models->nest();
		}

		return $models;
	}


	/**
	 * Get single model by URL
	 *
	 * @param string  URL slug of model
	 * @return object object of model information
	 */
	public function bySlug($slug)
	{
		// Find id
		$id = Helpers::getIdFromSlug($this->model->getTable(), $slug);

		$model = $this->model
			->with('translations')
			->whereHasOnlineTranslation()
			->files()
			->findOrFail($id);

		if ( ! count($model->translations)) {
			App::abort('404');
		}

		return $model;

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
		return true;
	}


	/**
	 * Sort models
	 *
	 * @param array  Data to update Pages
	 * @return boolean
	 */
	public function sort(array $data)
	{

		if (isset($data['nested']) and $data['nested']) {

			$position = 0;

			foreach ($data['item'] as $id => $parent) {
				
				$position ++;

				$parent = $parent ? : 0 ;

				$this->model->find($id)
					->update(array('position' => $position, 'parent' => $parent));

			}

		} else {

			foreach ($data['item'] as $key => $id) {
				
				$position = $key + 1;

				$this->model->find($id)
					->update(array('position' => $position));
				
			}

		}

		return true;

	}


	public function getPagesForSelect()
	{
		$pagesArray = Page::select('pages.id', 'title', 'locale')
			->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
			->where('locale', Config::get('app.locale'))
			->lists('id', 'title');
		$pagesArray = array_merge(array('' => '0'), $pagesArray);
		$pagesArray = array_flip($pagesArray);
		return $pagesArray;
	}


	public function getModulesForSelect()
	{
		$modulesArray = Config::get('app.modules');
		$selectModules = array('' => '');
		foreach ($modulesArray as $module => $property) {
			if ($property['menu']) {
				$selectModules[strtolower($module)] = Str::title(trans_choice('modules.'.strtolower($module.'.'.$module), 2));
			}
		}
		return $selectModules;
	}


	/**
	 * Delete model
	 *
	 * @return boolean
	 */
	public function delete($model)
	{
		if ($model->files) {
			$model->files->each(function($file){
				$file->delete();
			});
		}
		if ($model->delete()) {
			return true;
		}
		return false;
	}


    /**
     * Sync tags for model
     *
     * @param \Illuminate\Database\Eloquent\Model  $model
     * @param array  $tags
     * @return void
     */
    protected function syncTags($model, array $tags)
    {
        // Create or add tags
        $tagIds = array();

        if ($tags) {
            $found = $this->tag->findOrCreate( $tags );    
            foreach($found as $tag) {
                $tagIds[] = $tag->id;
            }
        }

        // Assign set tags to model
        $model->tags()->sync($tagIds);
    }


}