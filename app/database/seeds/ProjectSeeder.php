<?php

use TypiCMS\Models\User;

class ProjectSeeder extends Seeder {

	public function run()
	{
		DB::table('projects')->delete();
		DB::table('projects_translations')->delete();

		// `typicms`.`typi_pages`
		$typi_projects = array(
		  array('id' => '4','category_id' => '0','created_at' => '2013-10-28 09:05:08','updated_at' => '2013-10-28 09:05:08'),
		  array('id' => '5','category_id' => '0','created_at' => '2013-10-28 09:05:14','updated_at' => '2013-10-28 09:05:14'),
		  array('id' => '7','category_id' => '1','created_at' => '2013-10-28 09:36:25','updated_at' => '2013-10-28 09:36:25'),
		  array('id' => '8','category_id' => '1','created_at' => '2013-10-28 09:36:32','updated_at' => '2013-10-28 10:18:12'),
		  array('id' => '9','category_id' => '1','created_at' => '2013-10-28 09:36:58','updated_at' => '2013-10-28 09:36:58'),
		  array('id' => '10','category_id' => '2','created_at' => '2013-10-28 09:37:13','updated_at' => '2013-10-28 09:37:13'),
		  array('id' => '11','category_id' => '2','created_at' => '2013-10-28 09:37:18','updated_at' => '2013-10-28 09:37:20'),
		  array('id' => '12','category_id' => '2','created_at' => '2013-10-28 09:37:24','updated_at' => '2013-10-28 09:37:25'),
		  array('id' => '13','category_id' => '3','created_at' => '2013-10-28 09:37:40','updated_at' => '2013-10-28 09:37:57'),
		  array('id' => '14','category_id' => '3','created_at' => '2013-10-28 09:37:44','updated_at' => '2013-10-28 09:37:57'),
		  array('id' => '15','category_id' => '3','created_at' => '2013-10-28 09:37:50','updated_at' => '2013-10-28 09:37:57'),
		  array('id' => '16','category_id' => '3','created_at' => '2013-10-28 09:37:55','updated_at' => '2013-10-28 09:37:57'),
		  array('id' => '17','category_id' => '4','created_at' => '2013-10-28 09:38:16','updated_at' => '2013-10-28 09:38:54'),
		  array('id' => '18','category_id' => '4','created_at' => '2013-10-28 09:38:21','updated_at' => '2013-10-28 09:38:54'),
		  array('id' => '19','category_id' => '4','created_at' => '2013-10-28 09:38:34','updated_at' => '2013-10-28 09:38:55'),
		  array('id' => '20','category_id' => '4','created_at' => '2013-10-28 09:38:52','updated_at' => '2013-10-28 09:38:55')
		);

		// `typicms`.`typi_projects_translations`
		$typi_projects_translations = array(
		  array('id' => '19','project_id' => '7','lang' => 'fr','status' => '1','title' => 'Sandales','slug' => 'sandales','summary' => '','body' => '','created_at' => '2013-10-28 09:36:25','updated_at' => '2013-10-28 09:36:25'),
		  array('id' => '20','project_id' => '7','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:25','updated_at' => '2013-10-28 09:36:25'),
		  array('id' => '21','project_id' => '7','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:25','updated_at' => '2013-10-28 09:36:25'),
		  array('id' => '22','project_id' => '8','lang' => 'fr','status' => '0','title' => 'Cerf-volant','slug' => 'cerf-volant','summary' => '','body' => '','created_at' => '2013-10-28 09:36:32','updated_at' => '2013-10-28 10:18:12'),
		  array('id' => '23','project_id' => '8','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:32','updated_at' => '2013-10-28 09:36:32'),
		  array('id' => '24','project_id' => '8','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:32','updated_at' => '2013-10-28 09:36:32'),
		  array('id' => '25','project_id' => '9','lang' => 'fr','status' => '1','title' => 'Frisbee','slug' => 'frisbee','summary' => '','body' => '','created_at' => '2013-10-28 09:36:58','updated_at' => '2013-10-28 09:36:58'),
		  array('id' => '26','project_id' => '9','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:58','updated_at' => '2013-10-28 09:36:58'),
		  array('id' => '27','project_id' => '9','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:58','updated_at' => '2013-10-28 09:36:58'),
		  array('id' => '28','project_id' => '10','lang' => 'fr','status' => '1','title' => 'Rateau','slug' => 'rateau','summary' => '','body' => '','created_at' => '2013-10-28 09:37:13','updated_at' => '2013-10-28 09:37:13'),
		  array('id' => '29','project_id' => '10','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:13','updated_at' => '2013-10-28 09:37:13'),
		  array('id' => '30','project_id' => '10','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:13','updated_at' => '2013-10-28 09:37:13'),
		  array('id' => '31','project_id' => '11','lang' => 'fr','status' => '1','title' => 'Bottes','slug' => 'bottes','summary' => '','body' => '','created_at' => '2013-10-28 09:37:18','updated_at' => '2013-10-28 09:37:20'),
		  array('id' => '32','project_id' => '11','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:18','updated_at' => '2013-10-28 09:37:18'),
		  array('id' => '33','project_id' => '11','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:18','updated_at' => '2013-10-28 09:37:18'),
		  array('id' => '34','project_id' => '12','lang' => 'fr','status' => '1','title' => 'Parapluie','slug' => 'parapluie','summary' => '','body' => '','created_at' => '2013-10-28 09:37:24','updated_at' => '2013-10-28 09:37:25'),
		  array('id' => '35','project_id' => '12','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:24','updated_at' => '2013-10-28 09:37:24'),
		  array('id' => '36','project_id' => '12','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:24','updated_at' => '2013-10-28 09:37:24'),
		  array('id' => '37','project_id' => '13','lang' => 'fr','status' => '1','title' => 'Luge','slug' => 'luge','summary' => '','body' => '','created_at' => '2013-10-28 09:37:40','updated_at' => '2013-10-28 09:37:57'),
		  array('id' => '38','project_id' => '13','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:40','updated_at' => '2013-10-28 09:37:40'),
		  array('id' => '39','project_id' => '13','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:40','updated_at' => '2013-10-28 09:37:40'),
		  array('id' => '40','project_id' => '14','lang' => 'fr','status' => '1','title' => 'Ski','slug' => 'ski','summary' => '','body' => '','created_at' => '2013-10-28 09:37:44','updated_at' => '2013-10-28 09:37:57'),
		  array('id' => '41','project_id' => '14','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:44','updated_at' => '2013-10-28 09:37:44'),
		  array('id' => '42','project_id' => '14','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:44','updated_at' => '2013-10-28 09:37:44'),
		  array('id' => '43','project_id' => '15','lang' => 'fr','status' => '1','title' => 'Chasse-neige','slug' => 'chasse-neige','summary' => '','body' => '','created_at' => '2013-10-28 09:37:50','updated_at' => '2013-10-28 09:37:57'),
		  array('id' => '44','project_id' => '15','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:50','updated_at' => '2013-10-28 09:37:50'),
		  array('id' => '45','project_id' => '15','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:50','updated_at' => '2013-10-28 09:37:50'),
		  array('id' => '46','project_id' => '16','lang' => 'fr','status' => '1','title' => 'Chalet','slug' => 'chalet','summary' => '','body' => '','created_at' => '2013-10-28 09:37:55','updated_at' => '2013-10-28 09:37:57'),
		  array('id' => '47','project_id' => '16','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:55','updated_at' => '2013-10-28 09:37:55'),
		  array('id' => '48','project_id' => '16','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:37:55','updated_at' => '2013-10-28 09:37:55'),
		  array('id' => '49','project_id' => '17','lang' => 'fr','status' => '1','title' => 'Engrais','slug' => 'engrais','summary' => '','body' => '','created_at' => '2013-10-28 09:38:16','updated_at' => '2013-10-28 09:38:54'),
		  array('id' => '50','project_id' => '17','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:38:16','updated_at' => '2013-10-28 09:38:16'),
		  array('id' => '51','project_id' => '17','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:38:16','updated_at' => '2013-10-28 09:38:16'),
		  array('id' => '52','project_id' => '18','lang' => 'fr','status' => '1','title' => 'Terreau','slug' => 'terreau','summary' => '','body' => '','created_at' => '2013-10-28 09:38:21','updated_at' => '2013-10-28 09:38:54'),
		  array('id' => '53','project_id' => '18','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:38:21','updated_at' => '2013-10-28 09:38:21'),
		  array('id' => '54','project_id' => '18','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:38:21','updated_at' => '2013-10-28 09:38:21'),
		  array('id' => '55','project_id' => '19','lang' => 'fr','status' => '1','title' => 'Semences','slug' => 'semences','summary' => '','body' => '','created_at' => '2013-10-28 09:38:34','updated_at' => '2013-10-28 09:38:55'),
		  array('id' => '56','project_id' => '19','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:38:34','updated_at' => '2013-10-28 09:38:34'),
		  array('id' => '57','project_id' => '19','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:38:34','updated_at' => '2013-10-28 09:38:34'),
		  array('id' => '58','project_id' => '20','lang' => 'fr','status' => '1','title' => 'Nichoir','slug' => 'nichoir','summary' => '','body' => '','created_at' => '2013-10-28 09:38:52','updated_at' => '2013-10-28 09:38:55'),
		  array('id' => '59','project_id' => '20','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:38:52','updated_at' => '2013-10-28 09:38:52'),
		  array('id' => '60','project_id' => '20','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:38:52','updated_at' => '2013-10-28 09:38:52')
		);

		DB::table('projects')->insert( $typi_projects );
		DB::table('projects_translations')->insert( $typi_projects_translations );

	}

}