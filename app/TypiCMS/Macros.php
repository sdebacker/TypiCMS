<?php 
HTML::macro('adminList', function($items = array(), $properties = array())
{
	return with(new TypiCMS\Services\ListBuilder\ListBuilder(null, $properties))->build($items);
});

HTML::macro('th', function($field = '', $sortable = true, $label = true)
{
	return with(new TypiCMS\Services\Html)->th($field, $sortable, $label);
});
