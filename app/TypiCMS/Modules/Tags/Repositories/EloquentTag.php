<?php
namespace TypiCMS\Modules\Tags\Repositories;

use StdClass;
use DB;
use Str;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentTag extends RepositoriesAbstract implements TagInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @return StdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
    {
        $result = new StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->model->select(
            'id',
            'tag',
            DB::raw(
                "(SELECT COUNT(*) FROM `" .
                DB::getTablePrefix() .
                "taggables` WHERE `tag_id` = `" .
                DB::getTablePrefix() .
                "tags`.`id`) AS 'uses'"
            )
        )
        ->order();

        $models = $query->skip($limit * ($page - 1))
                        ->take($limit)
                        ->get();

        // Put items and totalItems in StdClass
        $result->totalItems = $this->model->count();
        $result->items = $models->all();

        return $result;
    }

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false)
    {
        $query = $this->model;

        $models = $query->lists('tag');

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
        $foundTags = $this->model->whereIn('tag', $tags)->get();

        $returnTags = array();

        if ($foundTags) {
            foreach ($foundTags as $tag) {
                $pos = array_search($tag->tag, $tags);

                // Add returned tags to array
                if ($pos !== false) {
                    $returnTags[] = $tag;
                    unset($tags[$pos]);
                }
            }
        }

        // Add remainings tags as new
        foreach ($tags as $tag) {
            $returnTags[] = $this->model->create(array(
                'tag' => $tag,
                'slug' => Str::slug($tag),
            ));
        }

        return $returnTags;
    }
}
