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
            $model->writeHistory($model, 'created');
        });
        static::updated(function ($model) {
            $model->writeHistory($model, 'updated');
        });
        static::deleted(function ($model) {
            $model->writeHistory($model, 'deleted');
        });
    }

    /**
     * Save history
     */
    public function writeHistory($model, $action)
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
