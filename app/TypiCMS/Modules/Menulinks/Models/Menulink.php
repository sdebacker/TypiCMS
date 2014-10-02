<?php
namespace TypiCMS\Modules\Menulinks\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
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
        'icon_class',
        'link_type',
        'has_categories',
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
     * A menulink can belongs to a page
     */
    public function page()
    {
        return $this->belongsTo('TypiCMS\Modules\Pages\Models\Page');
    }

    /**
     * Order of menulinks
     *
     * @param  Builder $query
     * @return Builder $query
     */
    public function scopeOrder(Builder $query)
    {
        return $query->orderBy('position')->orderBy('parent');
    }

    /**
     * A menulink belongs to a menu
     */
    public function menu()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Models\Menu');
    }

    /**
     * Custom collection
     *
     * @return NestedCollection object
     */
    public function newCollection(array $models = array())
    {
        return new NestedCollection($models);
    }
}
