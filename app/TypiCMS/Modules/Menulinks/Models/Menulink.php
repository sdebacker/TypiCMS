<?php
namespace TypiCMS\Modules\Menulinks\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use TypiCMS\Models\Base;
use TypiCMS\NestableCollection;
use TypiCMS\Presenters\PresentableTrait;

class Menulink extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Menulinks\Presenters\ModulePresenter';

    protected $fillable = array(
        'menu_id',
        'page_id',
        'parent_id',
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
     * A menulink belongs to a menu
     */
    public function menu()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Models\Menu');
    }

    /**
     * A menulink can belongs to a page
     */
    public function page()
    {
        return $this->belongsTo('TypiCMS\Modules\Pages\Models\Page');
    }

    /**
     * A menulink can have children
     */
    public function children()
    {
        return $this->hasMany('TypiCMS\Modules\Menulinks\Models\Menulink', 'parent_id');
    }

    /**
     * A menulink can have a parent
     */
    public function parent()
    {
        return $this->belongsTo('TypiCMS\Modules\Menulinks\Models\Menulink', 'parent_id');
    }

    /**
     * Menulinks are nestable
     *
     * @return NestableCollection object
     */
    public function newCollection(array $models = array())
    {
        return new NestableCollection($models, 'parent_id');
    }
}
