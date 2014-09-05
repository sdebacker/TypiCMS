<?php
namespace TypiCMS\Observers;

use Input;
use Croppa;
use FileUpload;
use Illuminate\Database\Eloquent\Model;

class FileObserver
{

    /**
     * On delete, unlink files and thumbs
     *
     * @param  Model $model eloquent
     * @return mixed false or void
     */
    public function deleted(Model $model)
    {
        if (! $attachments = $model->attachments) {
            return;
        }

        foreach ($attachments as $fieldname) {
            Croppa::delete('/uploads/' . $model->getTable() . '/' . $model->$fieldname);
        }
    }

    /**
     * On save, upload files
     *
     * @param  Model $model eloquent
     * @return mixed false or void
     */
    public function saving(Model $model)
    {
        if (! $attachments = $model->attachments) {
            return;
        }

        foreach ($attachments as $fieldname) {
            if (Input::hasFile($fieldname)) {
                // delete prev image
                $file = FileUpload::handle(Input::file($fieldname), 'uploads/' . $model->getTable());
                $model->$fieldname = $file['filename'];
            } else {
                $model->$fieldname = $model->getOriginal($fieldname);
            }
        }
    }

    /**
     * On update, delete previous file if changed
     *
     * @param  Model $model eloquent
     * @return mixed false or void
     */
    public function updated(Model $model)
    {
        if (! $attachments = $model->attachments) {
            return;
        }

        foreach ($attachments as $fieldname) {

            // Nothing to do if file did not change
            if ($model->getOriginal($fieldname) == $model->$fieldname) {
                return;
            }

            Croppa::delete('/uploads/' . $model->getTable() . '/' . $model->getOriginal($fieldname));

        }
    }
}
