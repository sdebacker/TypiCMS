<?php
namespace TypiCMS\Modules\Translations\Models;

use TypiCMS\Models\Base;

class Translation extends Base
{

    use \Dimsav\Translatable\Translatable;

    protected $fillable = array(
        'group',
        'key',
        // Translatable fields
        'translation'
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'translation'
    );

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'translations';

    /**
     * Lists
     */
    public $order = 'key';
    public $direction = 'asc';

}
