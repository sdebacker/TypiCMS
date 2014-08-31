<?php
namespace TypiCMS\Modules\Partners\Models;

use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class Partner extends Base
{

    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Partners\Presenters\PartnerPresenter';

    protected $fillable = array(
        'logo',
        // Translatable fields
        'title',
        'slug',
        'status',
        'website',
        'body',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'title',
        'slug',
        'status',
        'website',
        'body',
    );

    /**
     * List of fields that are file.
     *
     * @var array
     */
    public $attachments = array(
        'logo',
    );

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'partners';

    /**
     * lists
     */
    public $order = 'id';
    public $direction = 'desc';
}
