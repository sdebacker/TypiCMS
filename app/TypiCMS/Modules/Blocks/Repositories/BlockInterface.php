<?php
namespace TypiCMS\Modules\Blocks\Repositories;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\Repositories\RepositoryInterface;

interface BlockInterface extends RepositoryInterface
{

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return Collection
     */
    public function getAll(array $with = array('translations'), $all = false);

    /**
     * Get the content of a block
     *
     * @param  string $name unique name of the block
     * @param  array  $with linked
     * @return string       html
     */
    public function build($name = null, array $with = array('translations'));
}
