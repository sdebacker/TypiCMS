<?php
namespace TypiCMS\Modules\Sitemap\Controllers;

use App;
use URL;
use Config;
use Controller;

class PublicController extends Controller
{
    private $modules = array();

    public function __construct()
    {
        $this->modules = Config::get('sitemap.modules');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function generate()
    {
        // create new sitemap object
        $sitemap = App::make('sitemap');

        // set cache (key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean))
        // by default cache is disabled
        // $sitemap->setCache('laravel.sitemap', 3600);

        // check if there is cached sitemap and build new only if is not
        // if (! $sitemap->isCached()) {

            foreach (Config::get('app.locales') as $locale) {

                App::setLocale($locale);

                foreach ($this->modules as $module) {

                    if ($module != 'Pages') {
                        $items = $module::getAll();
                        foreach ($items as $item) {
                            $sitemap->add(
                                route($locale . '.' . strtolower($module) . '.' . 'slug', $item->slug),
                                $item->updated_at
                            );
                        }
                    }

                }

            }

        // }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');

    }
}
