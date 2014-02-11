<?php 
HTML::macro('adminList', function($items = array(), $properties = array())
{
	return with(new TypiCMS\Services\ListBuilder\ListBuilder(null, $properties))->build($items);
});
