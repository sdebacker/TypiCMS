<?php 
namespace TypiCMS\Services\Upload;

use Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Notification;

/**
* FileUpload
*/
class FileUpload
{
    
    /**
     * Handle the file upload. Returns the array on success, or false
     * on failure.
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile  $file
     * @param  String $path where to upload file
     * @return array|bool
     */
    public function handle(UploadedFile $file, $path = 'uploads')
    {
        $input = array();

        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        // $input['path']      = '../../'.$path;
        $input['path']      = $path;
        $input['extension'] = '.' . $file->getClientOriginalExtension();
        $input['filesize']  = $file->getClientSize();
        $input['mimetype']  = $file->getClientMimeType();
        $input['filename']  = $fileName . $input['extension'];

        $filecounter = 1;
        while (file_exists($input['path'] . '/' . $input['filename'])) {
            $input['filename'] = $fileName . '_' . $filecounter++ . $input['extension'];
        }

        try {
            $file->move($input['path'], $input['filename']);
            list($input['width'], $input['height']) = getimagesize($input['path'] . '/' . $input['filename']);
            return $input;
        } catch (FileException $e) {
            Notification::error($e->getmessage());
            return false;
        }

    }

}
