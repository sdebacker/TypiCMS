<?php
namespace TypiCMS\Traits;

use Cartalyst\Sentry\Users\UserNotFoundException;
use Sentry;
use TypiCMS\Modules\History\Models\History;

trait Historable {

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if (! $model->owner) {
                $model->writeHistory('created');
            }
        });
        static::updated(function ($model) {
            $action = 'updated';
            if (! $model->owner) {
                $model->writeHistory($action);
            } else {
                // When owner is dirty, history will be written for owner model
                if ($model->owner->getDirty()) {
                    return;
                }
                if ($model->isDirty('status')) {
                    $action = ($model->status) ? 'set online' : 'set offline' ;
                }
                $model->owner->writeHistory($model->locale . ' translation ' . $action);
            }
        });
        static::deleted(function ($model) {
            $model->writeHistory('deleted');
        });
    }

    /**
     * Save history
     */
    public function writeHistory($action)
    {
        $item                    = new History;
        $item->historable_id     = $this->getKey();
        $item->historable_type   = get_class($this);
        $item->user_id           = $this->getAuthUserId();
        $item->action            = $action;
        $item->save();
    }

    /**
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
