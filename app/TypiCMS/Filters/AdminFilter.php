<?php
namespace TypiCMS\Filters;

use Lang;
use Input;
use Config;
use Session;
use JavaScript;

/**
* Public filter
*/
class AdminFilter
{

    // Set App and Translator locale
    public function setLocale()
    {
        // If we have a query string like ?locale=xx
        if (Input::get('locale')) {
            // If locale is present in app.locales…
            if (in_array(Input::get('locale'), Config::get('app.locales'))) {
                // …store locale in session
                Session::put('locale', Input::get('locale'));
            }
        }
        // Set app.locale
        Config::set('app.locale', Session::get('locale', Config::get('app.locale')));
        // Set Translator locale to typicms.adminLocale config
        Lang::setLocale(Config::get('typicms.adminLocale'));
        // Set Locales to JS.
        JavaScript::put([
            'adminLocale' => Config::get('typicms.adminLocale'),
            'locales'     => Config::get('app.locales'),
        ]);
    }
}
