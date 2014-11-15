<?php
namespace TypiCMS\Modules\Galleries\Models;

use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;
use TypiCMS\Traits\Historable;

class Gallery extends Base
{

    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Galleries\Presenters\ModulePresenter';

    protected $fillable = array(
        'name',
        // Translatable columns
        'title',
        'slug',
        'status',
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
        'body',
    );

    protected $appends = ['status', 'title', 'files_count'];

    /**
     * One gallery has many files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('TypiCMS\Modules\Files\Models\File')->order();
    }

    /**
     * One gallery has many news.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function news()
    {
        return $this->morphedByMany('TypiCMS\Modules\News\Models\News');
    }

    /**
     * One gallery has many pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function pages()
    {
        return $this->morphedByMany('TypiCMS\Modules\Pages\Models\Page');
    }

    /**
     * Get files count
     * 
     * @return string title
     */
    public function getFilesCountAttribute()
    {
        return $this->files->count();
    }
}
