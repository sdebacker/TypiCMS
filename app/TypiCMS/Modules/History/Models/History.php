<?php
namespace TypiCMS\Modules\History\Models;

use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class History extends Base
{

    use PresentableTrait;

    protected $table = 'history';
    protected $presenter = 'TypiCMS\Modules\History\Presenters\ModulePresenter';

    protected $fillable = array(
        'historable_id',
        'historable_type',
        'user_id',
        'action',
    );

    protected $appends = ['user_name'];

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'history';

    /**
     * lists
     */
    public $order = 'id';
    public $direction = 'desc';

    /**
     * History item morph to model
     */
    public function historable()
    {
       return $this->morphTo();
    }

    /**
     * History item belongs to a user
     */
    public function user()
    {
       return $this->belongsTo('TypiCMS\Modules\Users\Models\User');
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserNameAttribute()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }
}
