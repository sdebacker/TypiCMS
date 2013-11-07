<?php

use TypiCMS\Models\User;

class PageSeeder extends Seeder {

	public function run()
	{
		DB::table('pages')->truncate();
		DB::table('pages_translations')->truncate();

		// `typicms`.`typi_pages`
		$typi_pages = array(
		  array('id' => '1','meta_robots_no_index' => '','meta_robots_no_follow' => '','rss_enabled' => '0','comments_enabled' => '0','is_home' => '1','css' => '','js' => '','template' => '','created_at' => '2013-09-03 21:57:44','updated_at' => '2013-09-11 20:26:35'),
		  array('id' => '2','meta_robots_no_index' => '','meta_robots_no_follow' => '','rss_enabled' => '0','comments_enabled' => '0','is_home' => '0','css' => '','js' => '','template' => 'contact','created_at' => '2013-09-03 21:58:30','updated_at' => '2013-09-11 20:59:15'),
		  array('id' => '29','meta_robots_no_index' => '','meta_robots_no_follow' => '','rss_enabled' => '0','comments_enabled' => '0','is_home' => '0','css' => '','js' => '','template' => '','created_at' => '2013-09-09 21:52:13','updated_at' => '2013-09-11 21:08:14')
		);

		// `typicms`.`typi_pages_translations`
		$typi_pages_translations = array(
		  array('id' => '1','page_id' => '1','lang' => 'fr','slug' => 'accueil', 'uri' => 'fr/accueil', 'title' => 'Accueil','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '2','page_id' => '1','lang' => 'nl','slug' => 'home', 'uri' => 'nl/home', 'title' => 'Home','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '3','page_id' => '1','lang' => 'en','slug' => 'home', 'uri' => 'en/home', 'title' => 'Home','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '4','page_id' => '2','lang' => 'fr','slug' => 'contactez-nous', 'uri' => 'fr/contactez-nous', 'title' => 'Contactez-nous','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '5','page_id' => '2','lang' => 'nl','slug' => 'contact-ons', 'uri' => 'nl/contact-ons', 'title' => 'Contact-ons','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '6','page_id' => '2','lang' => 'en','slug' => 'contact-us', 'uri' => 'en/contact-us', 'title' => 'Contact us','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '31','page_id' => '29','lang' => 'fr','slug' => 'quoi-de-neuf', 'uri' => 'fr/quoi-de-neuf', 'title' => 'Quoi de neuf ?','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '32','page_id' => '29','lang' => 'nl','slug' => 'informatie', 'uri' => 'nl/informatie', 'title' => 'Informatie','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '33','page_id' => '29','lang' => 'en','slug' => 'info', 'uri' => 'en/info', 'title' => 'Info','body' => '','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00')
		);

		DB::table('pages')->insert( $typi_pages );
		DB::table('pages_translations')->insert( $typi_pages_translations );

	}

}