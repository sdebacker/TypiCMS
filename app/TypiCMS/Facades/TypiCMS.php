<?php
namespace TypiCMS\Facades;

use Illuminate\Support\Facades\Facade;

class TypiCMS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'typicms';
    }
}
