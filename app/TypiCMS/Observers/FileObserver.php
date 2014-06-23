<?php
namespace TypiCMS\Observers;

use Input;

use Croppa;

use FileUpload;

class FileObserver
{

    /**
     * On delete, unlink files and thumbs
     * 
     * @param  model $model eloquent
     * @return mixed false or void
     */
    public function deleted($model)
    {
        if (! $attachements = $model->attachements) {
            return;
        }

        foreach ($attachements as $fieldname) {
            Croppa::delete('/uploads/' . $model->getTable() . '/' . $model->$fieldname);
        }
    }

    /**
     * On save, upload files
     * 
     * @param  model $model eloquent
     * @return mixed false or void
     */
    public function saving($model)
    {
        if (! $attachements = $model->attachements) {
            return;
        }

        foreach ($attachements as $fieldname) {
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
     * @param  model $model eloquent
     * @return mixed false or void
     */
    public function updated($model)
    {
        if (! $attachements = $model->attachements) {
            return;
        }

        foreach ($attachements as $fieldname) {

            // Nothing to do if file did not change
            if ($model->getOriginal($fieldname) == $model->$fieldname) {
                return;
            }

            Croppa::delete('/uploads/' . $model->getTable() . '/' . $model->getOriginal($fieldname));

        }
    }
}
