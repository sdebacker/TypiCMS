<?php
namespace TypiCMS\Modules\Blocks\Models;

use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class Block extends Base
{

    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Blocks\Presenters\BlockPresenter';

    protected $fillable = array(
        'name',
        // Translatable fields
        'status',
        'body',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'status',
        'body',
    );

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'blocks';

    /**
     * lists
     */
    public $order = 'name';
    public $direction = 'asc';
}
