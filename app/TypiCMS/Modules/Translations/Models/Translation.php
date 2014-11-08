<?php
namespace TypiCMS\Modules\Translations\Models;

use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class Translation extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Translations\Presenters\ModulePresenter';

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

    protected $appends = ['translation'];

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'translations';

    /**
     * Get translation attribute from translation table
     *
     * @return string
     */
    public function getTranslationAttribute($value)
    {
        return $this->translation;
    }
}
