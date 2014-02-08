<?php namespace TypiCMS\Models;

use Illuminate\Database\Eloquent\Collection;

use Dimsav\Translatable\Translatable;

use TypiCMS\NestedCollection;
use TypiCMS\Services\ListBuilder\ListBuilder;
use App;

class Menu extends Translatable {

	protected $fillable = array(
		'name',
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
	public function __call($name, $arguments = null)
	{
		if ( ! $arguments) {
			$arguments = array('class' => 'menu-' . $name . ' nav nav-pills');
		} else {
			$arguments = $arguments[0];
		}
		if ($name == 'languages') {
			return with(new ListBuilder)->languagesMenuHtml($arguments);
		}
		$items = App::make('TypiCMS\Repositories\Menulink\MenulinkInterface')->getMenu($name);
		return with(new ListBuilder($items))->buildPublic()->toHtml($arguments);
	}

	/**
	 * Relations
	 */
	public function menulinks()
	{
		return $this->hasMany('TypiCMS\Models\Menulink');
	}


	/**
	 * Validation rules
	 */
	public static $rules = array(
		'name' => 'required',
	);


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