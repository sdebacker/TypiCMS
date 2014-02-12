<?php 
HTML::macro('adminList', function($items = array(), $properties = array())
{
	return with(new TypiCMS\Services\ListBuilder\ListBuilder(null, $properties))->build($items);
});

HTML::macro('adminTable', function($items = array(), $properties = array())
{
	return with(new TypiCMS\Services\TableBuilder\TableBuilder(null, $properties))->build($items);
});
