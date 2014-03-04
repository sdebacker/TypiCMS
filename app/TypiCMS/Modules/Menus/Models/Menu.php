<?php namespace TypiCMS\Modules\Menus\Models;

use TypiCMS\Models\Base;
use TypiCMS\Services\ListBuilder\ListBuilder;

use App;

class Menu extends Base {

	use \Dimsav\Translatable\Translatable;

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
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menus';

	public $view = 'menus';
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
		if ($name == 'languages') {
			$attributes['id'] = 'nav-languages';
			return with(new ListBuilder)->languagesMenuHtml($attributes);
		}
		$menu = App::make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')->getMenu($name);
		$attributes['class'] = $menu->getClass();
		$attributes['id'] = 'nav-' . $name;
		return with(new ListBuilder($menu))->buildPublic()->toHtml($attributes);
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