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
        $locale      = Config::get('app.locale');
        $adminLocale = Config::get('typicms.adminLocale');
        $locales     = Config::get('app.locales');
        // If locale is present in app.locales…
        if (in_array(Input::get('locale'), $locales)) {
            // …store locale in session
            Session::put('locale', Input::get('locale'));
        }
        // Set app.locale
        Config::set('app.locale', Session::get('locale', $locale));
        // Set Translator locale to typicms.adminLocale config
        Lang::setLocale($adminLocale);

        $localesForJS = [];  
        foreach ($locales as $key => $locale) {
            $localesForJS[] = [
                'short' => $locale,
                'long' => trans('global.languages.' . $locale)
            ];
        }
        // Set Locales to JS.
        JavaScript::put([
            'adminLocale' => $adminLocale,
            'locales'     => $localesForJS,
            'locale'      => Config::get('app.locale'),
        ]);
    }
}
