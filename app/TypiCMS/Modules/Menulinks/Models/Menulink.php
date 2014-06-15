<?php
namespace TypiCMS\Modules\Menulinks\Models;

use Dimsav\Translatable\Translatable;

use TypiCMS\Models\Base;
use TypiCMS\NestedCollection;
use TypiCMS\Presenters\PresentableTrait;

class Menulink extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Menulinks\Presenters\ModulePresenter';

    protected $fillable = array(
        'menu_id',
        'page_id',
        'parent',
        'position',
        'target',
        'module_name',
        'restricted_to',
        'class',
        'link_type',
        // Translatable fields
        'title',
        'uri',
        'url',
        'status',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'title',
        'uri',
        'url',
        'status',
    );

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'menus.menulinks';

    /**
     * lists
     */
    public $order = 'position';
    public $direction = 'asc';

    /**
     * For nested collection
     *
     * @var array
     */
    public $children = array();

    /**
     * Scope from
     */
    public function scopeFrom($query, $relid)
    {
        return $query->where('menu_id', $relid);
    }

    /**
     * Relation
     */
    public function page()
    {
        return $this->belongsTo('TypiCMS\Modules\Pages\Models\Page');
    }

    /**
     * Relation
     */
    public function menu()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Models\Menu');
    }

    /**
     * Custom collection
     *
     * @return InvoiceCollection object
     */
    public function newCollection(array $models = array())
    {
        return new NestedCollection($models);
    }
}
