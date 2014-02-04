<?php

use TypiCMS\Models\User;

class MenuSeeder extends Seeder {

	public function run()
	{
		
		DB::table('menus')->truncate();
		DB::table('menus_translations')->truncate();
		DB::table('menulinks')->truncate();
		DB::table('menulinks_translations')->truncate();

		// `typicms`.`typi_menulinks`
		$typi_menulinks = array(
			array('id' => '1','menu_id' => '1','page_id' => '1','parent' => '0','position' => '1','target' => '','module_name' => '','restricted_to' => '','class' => '','link_type' => '','created_at' => '2013-09-03 22:08:05','updated_at' => '2014-02-04 18:58:25'),
			array('id' => '2','menu_id' => '1','page_id' => '2','parent' => '0','position' => '7','target' => '','module_name' => '','restricted_to' => '','class' => 'menu-contact','link_type' => '','created_at' => '2013-09-03 22:08:35','updated_at' => '2014-02-04 18:58:25'),
			array('id' => '16','menu_id' => '1','page_id' => '29','parent' => '0','position' => '2','target' => '','module_name' => 'poi','restricted_to' => '','class' => '','link_type' => '','created_at' => '2013-09-09 23:18:49','updated_at' => '2014-02-04 18:58:25'),
			array('id' => '17','menu_id' => '1','page_id' => '0','parent' => '0','position' => '3','target' => '','module_name' => 'events','restricted_to' => '','class' => '','link_type' => '','created_at' => '2013-10-05 19:30:30','updated_at' => '2014-02-04 18:58:25'),
			array('id' => '18','menu_id' => '1','page_id' => '0','parent' => '0','position' => '5','target' => '','module_name' => 'projects','restricted_to' => '','class' => '','link_type' => '','created_at' => '2013-10-05 19:31:09','updated_at' => '2014-02-04 18:58:25'),
			array('id' => '19','menu_id' => '2','page_id' => '2','parent' => '0','position' => '2','target' => '','module_name' => '','restricted_to' => '','class' => '','link_type' => '','created_at' => '2013-11-02 17:20:16','updated_at' => '2013-11-02 17:31:37'),
			array('id' => '20','menu_id' => '2','page_id' => '1','parent' => '0','position' => '1','target' => '','module_name' => '','restricted_to' => '','class' => '','link_type' => '','created_at' => '2013-11-02 17:20:43','updated_at' => '2013-11-02 17:31:37'),
			array('id' => '21','menu_id' => '1','page_id' => '0','parent' => '0','position' => '4','target' => '','module_name' => 'news','restricted_to' => '','class' => '','link_type' => '','created_at' => '2013-11-08 11:14:39','updated_at' => '2014-02-04 18:58:25'),
			array('id' => '22','menu_id' => '3','page_id' => '0','parent' => '0','position' => '0','target' => '_blank','module_name' => '','restricted_to' => '','class' => 'btn-facebook','link_type' => '','created_at' => '2014-02-04 18:30:11','updated_at' => '2014-02-04 18:30:17'),
			array('id' => '23','menu_id' => '3','page_id' => '0','parent' => '0','position' => '0','target' => '_blank','module_name' => '','restricted_to' => '','class' => 'btn-twitter','link_type' => '','created_at' => '2014-02-04 18:31:35','updated_at' => '2014-02-04 18:31:47'),
			array('id' => '24','menu_id' => '1','page_id' => '0','parent' => '0','position' => '6','target' => '','module_name' => 'places','restricted_to' => '','class' => '','link_type' => '','created_at' => '2014-02-04 18:58:20','updated_at' => '2014-02-04 18:59:32')
		);

		// `typicms`.`typi_menulinks_translations`
		$typi_menulinks_translations = array(
			array('id' => '1','menulink_id' => '1','lang' => 'fr','status' => '1','title' => 'Accueil','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '2','menulink_id' => '1','lang' => 'nl','status' => '1','title' => 'Home','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '3','menulink_id' => '1','lang' => 'en','status' => '1','title' => 'Home','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '4','menulink_id' => '2','lang' => 'fr','status' => '1','title' => 'Contact','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '5','menulink_id' => '2','lang' => 'nl','status' => '1','title' => 'Contact','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '6','menulink_id' => '2','lang' => 'en','status' => '1','title' => 'Contact','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '46','menulink_id' => '16','lang' => 'fr','status' => '1','title' => 'Infos','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '47','menulink_id' => '16','lang' => 'nl','status' => '1','title' => 'Info','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '48','menulink_id' => '16','lang' => 'en','status' => '1','title' => 'Info','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '49','menulink_id' => '17','lang' => 'fr','status' => '1','title' => 'Événements','url' => '','uri' => 'fr/evenements','created_at' => '2013-10-05 19:30:30','updated_at' => '2013-10-05 19:30:32'),
			array('id' => '50','menulink_id' => '17','lang' => 'nl','status' => '1','title' => 'Evenementen','url' => '','uri' => 'nl/evenementen','created_at' => '2013-10-05 19:30:30','updated_at' => '2013-10-05 19:31:48'),
			array('id' => '51','menulink_id' => '17','lang' => 'en','status' => '1','title' => 'Events','url' => '','uri' => 'en/events','created_at' => '2013-10-05 19:30:30','updated_at' => '2013-10-05 19:31:51'),
			array('id' => '52','menulink_id' => '18','lang' => 'fr','status' => '1','title' => 'Projets','url' => '','uri' => 'fr/projets','created_at' => '2013-10-05 19:31:09','updated_at' => '2013-10-05 19:31:11'),
			array('id' => '53','menulink_id' => '18','lang' => 'nl','status' => '1','title' => 'Projecten','url' => '','uri' => 'nl/projecten','created_at' => '2013-10-05 19:31:09','updated_at' => '2013-10-05 19:31:49'),
			array('id' => '54','menulink_id' => '18','lang' => 'en','status' => '1','title' => 'Projects','url' => '','uri' => 'en/projects','created_at' => '2013-10-05 19:31:09','updated_at' => '2013-10-05 19:31:51'),
			array('id' => '55','menulink_id' => '19','lang' => 'fr','status' => '1','title' => 'Contact','url' => '','uri' => '','created_at' => '2013-11-02 17:20:16','updated_at' => '2013-11-02 17:20:18'),
			array('id' => '56','menulink_id' => '19','lang' => 'nl','status' => '1','title' => 'Contact','url' => '','uri' => '','created_at' => '2013-11-02 17:20:16','updated_at' => '2013-11-02 17:20:16'),
			array('id' => '57','menulink_id' => '19','lang' => 'en','status' => '1','title' => 'Contact','url' => '','uri' => '','created_at' => '2013-11-02 17:20:16','updated_at' => '2013-11-02 17:20:16'),
			array('id' => '58','menulink_id' => '20','lang' => 'fr','status' => '1','title' => 'Accueil','url' => '','uri' => '','created_at' => '2013-11-02 17:20:43','updated_at' => '2013-11-02 17:20:51'),
			array('id' => '59','menulink_id' => '20','lang' => 'nl','status' => '1','title' => 'Home','url' => '','uri' => '','created_at' => '2013-11-02 17:20:43','updated_at' => '2013-11-02 17:20:47'),
			array('id' => '60','menulink_id' => '20','lang' => 'en','status' => '1','title' => 'Home','url' => '','uri' => '','created_at' => '2013-11-02 17:20:43','updated_at' => '2013-11-02 17:20:44'),
			array('id' => '61','menulink_id' => '21','lang' => 'fr','status' => '1','title' => 'Actualités','url' => '','uri' => 'fr/actualites','created_at' => '2013-11-08 11:14:39','updated_at' => '2013-11-08 11:14:39'),
			array('id' => '62','menulink_id' => '21','lang' => 'nl','status' => '1','title' => 'Nieuws','url' => '','uri' => 'nl/nieuws','created_at' => '2013-11-08 11:14:39','updated_at' => '2013-11-08 11:14:39'),
			array('id' => '63','menulink_id' => '21','lang' => 'en','status' => '1','title' => 'News','url' => '','uri' => 'en/news','created_at' => '2013-11-08 11:14:39','updated_at' => '2013-11-08 11:14:39'),
			array('id' => '64','menulink_id' => '22','lang' => 'fr','status' => '1','title' => 'Facebook','url' => 'https://www.facebook.com/pages/Typi-Design/101975113206089','uri' => '','created_at' => '2014-02-04 18:30:11','updated_at' => '2014-02-04 18:30:17'),
			array('id' => '65','menulink_id' => '22','lang' => 'nl','status' => '1','title' => 'Facebook','url' => 'https://www.facebook.com/pages/Typi-Design/101975113206089','uri' => '','created_at' => '2014-02-04 18:30:11','updated_at' => '2014-02-04 18:30:17'),
			array('id' => '66','menulink_id' => '22','lang' => 'en','status' => '1','title' => 'Facebook','url' => 'https://www.facebook.com/pages/Typi-Design/101975113206089','uri' => '','created_at' => '2014-02-04 18:30:11','updated_at' => '2014-02-04 18:30:17'),
			array('id' => '67','menulink_id' => '23','lang' => 'fr','status' => '1','title' => 'Twitter','url' => 'https://twitter.com/TypiDesign','uri' => '','created_at' => '2014-02-04 18:31:35','updated_at' => '2014-02-04 18:31:47'),
			array('id' => '68','menulink_id' => '23','lang' => 'nl','status' => '1','title' => 'Twitter','url' => 'https://twitter.com/TypiDesign','uri' => '','created_at' => '2014-02-04 18:31:35','updated_at' => '2014-02-04 18:31:44'),
			array('id' => '69','menulink_id' => '23','lang' => 'en','status' => '1','title' => 'Twitter','url' => 'https://twitter.com/TypiDesign','uri' => '','created_at' => '2014-02-04 18:31:35','updated_at' => '2014-02-04 18:31:42'),
			array('id' => '70','menulink_id' => '24','lang' => 'fr','status' => '1','title' => 'Adresses','url' => '','uri' => 'fr/adresses','created_at' => '2014-02-04 18:58:20','updated_at' => '2014-02-04 18:59:32'),
			array('id' => '71','menulink_id' => '24','lang' => 'nl','status' => '1','title' => 'Adres','url' => '','uri' => 'nl/adres','created_at' => '2014-02-04 18:58:20','updated_at' => '2014-02-04 18:59:32'),
			array('id' => '72','menulink_id' => '24','lang' => 'en','status' => '1','title' => 'Addresses','url' => '','uri' => 'en/addresses','created_at' => '2014-02-04 18:58:20','updated_at' => '2014-02-04 18:59:32')
		);

		// `typicms`.`typi_menus`
		$typi_menus = array(
			array('id' => '1','name' => 'main','created_at' => '2013-09-03 22:05:21','updated_at' => '2013-09-03 22:05:21'),
			array('id' => '2','name' => 'footer','created_at' => '2013-09-03 22:05:42','updated_at' => '2013-09-03 22:05:42'),
			array('id' => '3','name' => 'social','created_at' => '2014-02-04 18:27:18','updated_at' => '2014-02-04 18:35:01')
		);

		// `typicms`.`typi_menus_translations`
		$typi_menus_translations = array(
			array('id' => '1','menu_id' => '1','lang' => 'fr','status' => '1','title' => 'Principal','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '2','menu_id' => '1','lang' => 'nl','status' => '1','title' => 'Main','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '3','menu_id' => '1','lang' => 'en','status' => '1','title' => 'Main','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '4','menu_id' => '2','lang' => 'fr','status' => '1','title' => 'Pied de site','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '5','menu_id' => '2','lang' => 'nl','status' => '1','title' => 'Footer','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '6','menu_id' => '2','lang' => 'en','status' => '1','title' => 'Footer','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
			array('id' => '7','menu_id' => '3','lang' => 'fr','status' => '1','title' => 'Réseaux sociaux','created_at' => '2014-02-04 18:27:18','updated_at' => '2014-02-04 18:35:01'),
			array('id' => '8','menu_id' => '3','lang' => 'nl','status' => '1','title' => 'Sociale netwerken','created_at' => '2014-02-04 18:27:18','updated_at' => '2014-02-04 18:35:01'),
			array('id' => '9','menu_id' => '3','lang' => 'en','status' => '1','title' => 'Social networks','created_at' => '2014-02-04 18:27:18','updated_at' => '2014-02-04 18:35:01')
		);

		DB::table('menus')->insert( $typi_menus );
		DB::table('menus_translations')->insert( $typi_menus_translations );
		DB::table('menulinks')->insert( $typi_menulinks );
		DB::table('menulinks_translations')->insert( $typi_menulinks_translations );

	}

}