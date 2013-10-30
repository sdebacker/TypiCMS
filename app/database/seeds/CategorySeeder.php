<?php

use TypiCMS\Models\User;

class CategorySeeder extends Seeder {

	public function run()
	{
		DB::table('categories')->delete();
		DB::table('categories_translations')->delete();

		// `typicms`.`typi_pages`
		$typi_categories = array(
		  array('id' => '1','created_at' => '2013-10-27 21:57:44','updated_at' => '2013-10-27 20:26:35'),
		  array('id' => '2','created_at' => '2013-10-27 21:58:30','updated_at' => '2013-10-27 20:59:15'),
		  array('id' => '3','created_at' => '2013-10-27 21:52:13','updated_at' => '2013-10-27 21:08:14'),
		  array('id' => '4','created_at' => '2013-10-27 21:52:13','updated_at' => '2013-10-27 21:08:14')
		);

		// `typicms`.`typi_categories_translations`
		$typi_categories_translations = array(
		  array('id' => '1','category_id' => '1','lang' => 'fr','slug' => 'ete', 'title' => 'Été', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '2','category_id' => '1','lang' => 'nl','slug' => 'zomer', 'title' => 'Zomer', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '3','category_id' => '1','lang' => 'en','slug' => 'summer', 'title' => 'Summer', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '4','category_id' => '2','lang' => 'fr','slug' => 'automne', 'title' => 'Automne', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '5','category_id' => '2','lang' => 'nl','slug' => 'vallen', 'title' => 'Vallen', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '6','category_id' => '2','lang' => 'en','slug' => 'fall', 'title' => 'Fall', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '7','category_id' => '3','lang' => 'fr','slug' => 'hiver', 'title' => 'Hiver', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '8','category_id' => '3','lang' => 'nl','slug' => 'winter', 'title' => 'Winter', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '9','category_id' => '3','lang' => 'en','slug' => 'winter', 'title' => 'Winter', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '10','category_id' => '4','lang' => 'fr','slug' => 'printemps', 'title' => 'Printemps', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '11','category_id' => '4','lang' => 'nl','slug' => 'lente', 'title' => 'Lente', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
		  array('id' => '12','category_id' => '4','lang' => 'en','slug' => 'spring', 'title' => 'Spring', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00')
		);

		DB::table('categories')->insert( $typi_categories );
		DB::table('categories_translations')->insert( $typi_categories_translations );

	}

}