<?php
namespace TypiCMS\Providers;

use Illuminate\Support\ServiceProvider;
use TypiCMS\Services\Upload\FileUpload;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['upload.file'] = $this->app->share(function ($app) {
            return new FileUpload;
        });
    }
}
