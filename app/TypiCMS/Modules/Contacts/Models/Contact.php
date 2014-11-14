<?php
namespace TypiCMS\Modules\Contacts\Models;

use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;
use TypiCMS\Traits\Historable;

class Contact extends Base
{

    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Contacts\Presenters\ModulePresenter';

    protected $fillable = array(
        'title',
        'first_name',
        'last_name',
        'email',
        'language',
        'website',
        'company',
        'address',
        'postcode',
        'city',
        'country',
        'phone',
        'mobile',
        'fax',
        'message',
    );

    protected $appends = [];

    /**
     * Get title attribute from translation table
     * and append it to main model attributes
     * @return string title
     */
    public function getTitleAttribute($value)
    {
        return $value;
    }
}
