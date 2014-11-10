<?php
namespace TypiCMS\Traits;

use Cartalyst\Sentry\Users\UserNotFoundException;
use Sentry;
use TypiCMS\Modules\History\Models\History;

trait Historable {

    /**
     * boot method
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if (! $model->owner) {
                $model->writeHistory('created', $model->present()->title);
            }
        });
        static::updated(function ($model) {
            $action = 'updated';
            if (! $model->owner) { // if model has no owner, $model is not a translation
                $model->writeHistory($action);
            } else { // if model has owner, $model is a translation
                // When owner is dirty, history will be written for owner model
                if ($model->owner->getDirty()) {
                    return;
                }
                // if status change, getDirty returns updated_at and status columns 
                if (count($model->getDirty()) == 2 && $model->isDirty('status')) {
                    $action = $model->status ? 'set online' : 'set offline' ;
                }
                $model->owner->writeHistory($action, $model->owner->present()->title, $model->locale);
            }
        });
        static::deleted(function ($model) {
            $model->writeHistory('deleted', $model->present()->title);
        });
    }

    /**
     * Write History row
     * 
     * @param  string $action
     * @param  string $title
     * @param  string $locale
     * @return void
     */
    public function writeHistory($action, $title = null, $locale = null)
    {
        $item                    = new History;
        $item->historable_id     = $this->getKey();
        $item->historable_type   = get_class($this);
        $item->user_id           = $this->getAuthUserId();
        $item->title             = $title;
        $item->locale            = $locale;
        $item->historable_table  = $this->getTable();
        $item->action            = $action;
        $item->save();
    }

    /**
     * Get current user id
     * 
     * @return int|null
     */
    private function getAuthUserId()
    {
        $userId = null;
        try {
            // Get the current active/logged in user
            $user = Sentry::getUser();
            $userId = $user->id;
        } catch (UserNotFoundException $e) {
            // User wasn't found, should only happen if the user was deleted
            // when they were already logged in or had a "remember me" cookie set
            // and they were deleted.
        }
        return $userId;
    }

    /**
     * Model has history
     */
    public function history()
    {
        return $this->morphMany('TypiCMS\Modules\History\Models\History', 'historable');
    }
}
