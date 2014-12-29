<?php
namespace TypiCMS\Modules\Pages\Events;

use Config;
use Illuminate\Events\Dispatcher;
use TypiCMS\Modules\Pages\Models\Page;

class ResetChildren {

    /**
     * Recursive method for emptying children’s uri
     * UriObserver will rebuild uris
     * 
     * @param  Page $page
     * @return void
     */
    public function resetChildrenUri(Page $page)
    {
        foreach ($page->children as $childPage) {
            foreach (Config::get('app.locales') as $locale) {
                if (is_null($page->translate($locale)->uri)) {
                    $childPage->translate($locale)->uri = null;
                } else {
                    $childPage->translate($locale)->uri = '';
                }
            }
            $childPage->save();
            $this->resetChildrenUri($childPage);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher  $events
     * @return array
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen('page.resetChildrenUri', 'TypiCMS\Modules\Pages\Events\ResetChildren@resetChildrenUri');
    }
}
