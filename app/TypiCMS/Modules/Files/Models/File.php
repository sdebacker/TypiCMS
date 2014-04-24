<?php
namespace TypiCMS\Modules\Files\Models;

use Croppa;

use TypiCMS\Models\Base;

class File extends Base
{

    use \Dimsav\Translatable\Translatable;

    protected $fillable = array(
        'fileable_id',
        'fileable_type',
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
     * Polymorphic relation.
     */
    public function fileable()
    {
        return $this->morphTo();
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
