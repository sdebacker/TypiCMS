<?php namespace App\Controllers;

use View;
use Config;
use Redirect;

class PublicController extends BaseController {

    /**
     * Show lang chooser, redirect to browser lang or redirect to default lang
     *
     * @return void
     */
    public function root()
    {
        $locales = Config::get('app.locales');

        // If we don’t want the lang chooser, redirect to user language
        if ( ! Config::get('typicms.langChooser')) {

            $locale = substr(getenv('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            ! in_array($locale, $locales) and $locale = Config::get('app.locale');

            return Redirect::route($locale);

        }

        $this->title['parent'] = 'Choose your language';

        $this->layout->content = View::make('public.root')
            ->with('locales', $locales);
    }

}