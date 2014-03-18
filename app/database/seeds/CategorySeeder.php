<?php

class CategorySeeder extends Seeder
{
    public function run()
    {

        $typi_categories = array(
            array('id' => '1','created_at' => '2013-10-27 21:57:44','updated_at' => '2013-10-27 20:26:35'),
            array('id' => '2','created_at' => '2013-10-27 21:58:30','updated_at' => '2013-10-27 20:59:15'),
            array('id' => '3','created_at' => '2013-10-27 21:52:13','updated_at' => '2013-10-27 21:08:14'),
            array('id' => '4','created_at' => '2013-10-27 21:52:13','updated_at' => '2013-10-27 21:08:14')
        );

        $typi_category_translations = array(
            array('id' => '1','category_id' => '1','locale' => 'fr','slug' => 'ete', 'title' => 'Été', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '2','category_id' => '1','locale' => 'nl','slug' => 'zomer', 'title' => 'Zomer', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '3','category_id' => '1','locale' => 'en','slug' => 'summer', 'title' => 'Summer', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '4','category_id' => '2','locale' => 'fr','slug' => 'automne', 'title' => 'Automne', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '5','category_id' => '2','locale' => 'nl','slug' => 'vallen', 'title' => 'Vallen', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '6','category_id' => '2','locale' => 'en','slug' => 'fall', 'title' => 'Fall', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '7','category_id' => '3','locale' => 'fr','slug' => 'hiver', 'title' => 'Hiver', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '8','category_id' => '3','locale' => 'nl','slug' => 'winter', 'title' => 'Winter', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '9','category_id' => '3','locale' => 'en','slug' => 'winter', 'title' => 'Winter', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '10','category_id' => '4','locale' => 'fr','slug' => 'printemps', 'title' => 'Printemps', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '11','category_id' => '4','locale' => 'nl','slug' => 'lente', 'title' => 'Lente', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '12','category_id' => '4','locale' => 'en','slug' => 'spring', 'title' => 'Spring', 'status' => '1', 'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00')
        );

        DB::table('categories')->insert( $typi_categories );
        DB::table('category_translations')->insert( $typi_category_translations );

    }

}
