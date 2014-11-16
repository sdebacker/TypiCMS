<?php
namespace TypiCMS\Observers;

use Croppa;
use File;
use FileUpload;
use Illuminate\Database\Eloquent\Model;
use Input;

class FileObserver
{

    /**
     * On delete, unlink files and thumbs
     * @param  Model $model eloquent
     * @return mixed false or void
     */
    public function deleted(Model $model)
    {
        if (! $attachments = $model->attachments) {
            return;
        }

        foreach ($attachments as $fieldname) {
            $file = '/uploads/' . $model->getTable() . '/' . $model->getOriginal($fieldname);
            $this->delete($file);
        }
    }

    /**
     * Delete file and thumbs
     * 
     * @param  string $file
     * @return void
     */
    public function delete($file)
    {
        Croppa::delete($file);
        File::delete(public_path() . $file);
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
                if ($model->getTable() == 'files') {
                    $model->fill($file);
                }
            } else {
                if ($model->$fieldname == 'delete') {
                    $model->$fieldname = null;
                } else {
                    $model->$fieldname = $model->getOriginal($fieldname);
                }
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
            if (! $model->isDirty($fieldname)) {
                continue;
            }

            $file = '/uploads/' . $model->getTable() . '/' . $model->getOriginal($fieldname);
            $this->delete($file);

        }
    }
}
