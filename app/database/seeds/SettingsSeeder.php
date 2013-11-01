<?php

use TypiCMS\Models\User;

class SettingsSeeder extends Seeder {

	public function run()
	{
		DB::table('settings')->delete();

		$typi_settings = array(
			array('id' => '1','package' => NULL,'group' => 'fr','key' => 'website_title','value' => 'Typi CMS (fr)','type' => NULL,'environment' => NULL,'created_at' => '2013-11-01 12:46:46','updated_at' => '2013-11-01 16:40:15'),
			array('id' => '2','package' => NULL,'group' => 'fr','key' => 'status','value' => '1','type' => NULL,'environment' => NULL,'created_at' => '2013-11-01 12:46:46','updated_at' => '2013-11-01 12:47:17'),
			array('id' => '3','package' => NULL,'group' => 'nl','key' => 'website_title','value' => 'Typi CMS (nl)','type' => NULL,'environment' => NULL,'created_at' => '2013-11-01 12:46:46','updated_at' => '2013-11-01 13:06:48'),
			array('id' => '4','package' => NULL,'group' => 'nl','key' => 'status','value' => '1','type' => NULL,'environment' => NULL,'created_at' => '2013-11-01 12:46:46','updated_at' => '2013-11-01 12:46:46'),
			array('id' => '5','package' => NULL,'group' => 'en','key' => 'website_title','value' => 'Typi CMS (en)','type' => NULL,'environment' => NULL,'created_at' => '2013-11-01 12:46:46','updated_at' => '2013-11-01 13:06:48'),
			array('id' => '6','package' => NULL,'group' => 'en','key' => 'status','value' => '1','type' => NULL,'environment' => NULL,'created_at' => '2013-11-01 12:46:46','updated_at' => '2013-11-01 13:10:45')
		);

		DB::table('settings')->insert( $typi_settings );

	}

}