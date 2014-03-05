<?php 
HTML::macro('th', function($field = '', $sortable = true, $label = true)
{
	return with(new TypiCMS\Services\Html)->th($field, $sortable, $label);
});
