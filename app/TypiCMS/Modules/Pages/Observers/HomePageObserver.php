<?php
namespace TypiCMS\Modules\Pages\Observers;

use TypiCMS\Modules\Pages\Models\Page;

class HomePageObserver
{
    /**
     * If a new homepage is defined, cancel previous homepage.
     * 
     * @param  Model $model eloquent
     * @return void
     */
    public function saving(Page $model)
    {
        if ($model->is_home) {
            $query = Page::where('is_home', 1);
            if ($model->id) {
                $query->where('id', '!=', $model->id);
            }
            $query->update(array('is_home' => 0));
        }
    }
}
