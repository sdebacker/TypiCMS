<?php

use TypiCMS\Models\User;

class TranslationSeeder extends Seeder {

	public function run()
	{

		$typi_translations = array(
			array('id'=>1,'key'=>'public.More'),
			array('id'=>2,'key'=>'public.Thing'),
		);

		$typi_translation_translations = array(
			array('translation_id'=>1,'locale'=>'fr','translation'=>'En savoir plus','created_at'=>'2014-02-28 22:50:19','updated_at'=>'2014-02-28 22:50:19'),
			array('translation_id'=>1,'locale'=>'en','translation'=>'More','created_at'=>'2014-02-28 22:50:19','updated_at'=>'2014-02-28 22:50:19'),
			array('translation_id'=>1,'locale'=>'nl','translation'=>'Meer','created_at'=>'2014-02-28 22:50:51','updated_at'=>'2014-02-28 22:50:51'),
			array('translation_id'=>2,'locale'=>'fr','translation'=>'Chose','created_at'=>'2014-02-28 22:50:19','updated_at'=>'2014-02-28 22:50:19'),
			array('translation_id'=>2,'locale'=>'en','translation'=>'Thing','created_at'=>'2014-02-28 22:50:19','updated_at'=>'2014-02-28 22:50:19'),
			array('translation_id'=>2,'locale'=>'nl','translation'=>'Ding','created_at'=>'2014-02-28 22:50:51','updated_at'=>'2014-02-28 22:50:51'),
		);

		DB::table('translations')->insert( $typi_translations );
		DB::table('translation_translations')->insert( $typi_translation_translations );

	}

}