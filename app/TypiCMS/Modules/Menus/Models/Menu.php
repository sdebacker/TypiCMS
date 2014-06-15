<?php
namespace TypiCMS\Modules\Menus\Models;

use App;
use HTML;

use Dimsav\Translatable\Translatable;

use TypiCMS\Models\Base;
use TypiCMS\Presenters\Presenter;
use TypiCMS\Presenters\PresentableTrait;

class Menu extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Menus\Presenters\ModulePresenter';

    protected $fillable = array(
        'name',
        'class',
        // Translatable fields
        'title',
        'status',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'title',
        'status',
    );

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'menus';

    /**
     * lists
     */
    public $order = 'name';
    public $direction = 'asc';

    /**
     * Build a menu
     *
     * @return menu html
     */
    public static function build($name, $attributes = array())
    {
        
        $items = App::make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')->getMenu($name);
        $attributes['class'] = $items->getClass();
        $attributes['id'] = 'nav-' . $name;
        $attributes['role'] = 'menu';

        return HTML::menu($items, $attributes);
    }

    /**
     * Relations
     */
    public function menulinks()
    {
        return $this->hasMany('TypiCMS\Modules\Menulinks\Models\Menulink');
    }

    /**
     * Validation rules
     */
    public static $rules = array(
        'name' => 'required',
    );
}
