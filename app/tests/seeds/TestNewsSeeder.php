<?php

class TestNewsSeeder extends Seeder {

    public function run()
    {

        $typi_news = array(
            array('id' => '1','date' => '2014-03-20 12:33:00','created_at' => '2014-03-04 12:33:37','updated_at' => '2014-03-04 12:33:37'),
        );

        $typi_news_translations = array(
            array('id' => '1','news_id' => '1','locale' => 'fr','status' => '0','title' => 'test de pge','slug' => 'test-de-pge','summary' => '','body' => '','created_at' => '2014-03-04 12:33:37','updated_at' => '2014-03-04 12:33:37'),
            array('id' => '2','news_id' => '1','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2014-03-04 12:33:37','updated_at' => '2014-03-04 12:33:37'),
            array('id' => '3','news_id' => '1','locale' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2014-03-04 12:33:37','updated_at' => '2014-03-04 12:33:37'),
        );

        DB::table('news')->insert( $typi_news );
        DB::table('news_translations')->insert( $typi_news_translations );

    }

}