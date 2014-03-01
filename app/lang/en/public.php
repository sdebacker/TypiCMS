<?php 
$translations = App::make('db')
	->table('translations')
	->join('translation_translations', 'translations.id', '=', 'translation_translations.translation_id')
	->where('locale', App::getLocale())
	->lists('translation', 'key');
return $translations;
