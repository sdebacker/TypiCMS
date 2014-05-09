<?php
namespace TypiCMS\Modules\Files\Models;

use Croppa;

use TypiCMS\Models\Base;

class File extends Base
{

    use \Dimsav\Translatable\Translatable;
    use \TypiCMS\Presenters\PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Files\Presenters\FilePresenter';

    protected $fillable = array(
        'gallery_id',
        'folder_id',
        'user_id',
        'type',
        'name',
        'filename',
        'path',
        'extension',
        'mimetype',
        'width',
        'height',
        'filesize',
        'download_count',
        'position',
        // Translatable fields
        'keywords',
        'description',
        'alt_attribute',
        'status',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'keywords',
        'description',
        'alt_attribute',
        'status',
    );

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'files';

    /**
     * lists
     */
    public $order = 'position';
    public $direction = 'asc';

    /**
     * One file belongs to one gallery.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function gallery()
    {
        return $this->belongsTo('TypiCMS\Modules\Galleries\Models\Gallery');
    }

    /**
     * Observers
     */
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            Croppa::delete($model->path . '/' . $model->filename);
        });

    }
}
