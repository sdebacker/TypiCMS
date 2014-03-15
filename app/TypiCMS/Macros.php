<?php 
HTML::macro('th', function($field = '', $defaultOrder = null, $sortable = true, $label = true)
{
	return with(new TypiCMS\Services\Html)->th($field, $defaultOrder, $sortable, $label);
});
