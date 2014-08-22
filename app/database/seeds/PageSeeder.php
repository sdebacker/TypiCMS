<?php

class PageSeeder extends Seeder
{
    public function run()
    {

        $typi_pages = array(
            array('id' => '1','meta_robots_no_index' => '','meta_robots_no_follow' => '','rss_enabled' => '0','comments_enabled' => '0','is_home' => '1','css' => '','js' => '','template' => 'home','created_at' => '2013-09-03 21:57:44','updated_at' => '2013-09-11 20:26:35'),
            array('id' => '2','meta_robots_no_index' => '','meta_robots_no_follow' => '','rss_enabled' => '0','comments_enabled' => '0','is_home' => '0','css' => '','js' => '','template' => '','created_at' => '2013-09-03 21:58:30','updated_at' => '2013-09-11 20:59:15'),
            array('id' => '29','meta_robots_no_index' => '','meta_robots_no_follow' => '','rss_enabled' => '0','comments_enabled' => '0','is_home' => '0','css' => '','js' => '','template' => '','created_at' => '2013-09-09 21:52:13','updated_at' => '2013-09-11 21:08:14')
        );

        $typi_page_translations = array(
            array('id' => '1','page_id' => '1','locale' => 'fr','slug' => 'accueil', 'uri' => 'fr/accueil', 'title' => 'Accueil','body' => '<h2>Accueil</h2><p>Bienvenue ici.</p>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '2','page_id' => '1','locale' => 'nl','slug' => 'home', 'uri' => 'nl/home', 'title' => 'Home','body' => '<h2>Home</h2><p>Welkom hier.</p>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '3','page_id' => '1','locale' => 'en','slug' => 'home', 'uri' => 'en/home', 'title' => 'Home','body' => '<h2>Home</h2><p>Welcome here.</p>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '4','page_id' => '2','locale' => 'fr','slug' => 'contactez-nous', 'uri' => 'fr/contactez-nous', 'title' => 'Contactez-nous','body' => '<h2>Contactez-nous</h2><p>Typi Design <br>Rue Vanderkindere 467</p>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '5','page_id' => '2','locale' => 'nl','slug' => 'contact-ons', 'uri' => 'nl/contact-ons', 'title' => 'Contact-ons','body' => '<h2>Contact-ons</h2><p>Typi Design <br>Rue Vanderkindere 467</p>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '6','page_id' => '2','locale' => 'en','slug' => 'contact-us', 'uri' => 'en/contact-us', 'title' => 'Contact us','body' => '<h2>Contact us</h2><p>Typi Design <br>Rue Vanderkindere 467</p>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '31','page_id' => '29','locale' => 'fr','slug' => 'quoi-de-neuf', 'uri' => 'fr/quoi-de-neuf', 'title' => 'Quoi de neuf ?','body' => '<h2>Quoi de neuf ?</h2>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '32','page_id' => '29','locale' => 'nl','slug' => 'informatie', 'uri' => 'nl/informatie', 'title' => 'Informatie','body' => '<h2>Informatie</h2>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '33','page_id' => '29','locale' => 'en','slug' => 'info', 'uri' => 'en/info', 'title' => 'Info','body' => '<h2>Info</h2>','status' => '1','meta_title' => '','meta_keywords' => '','meta_description' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00')
        );

        DB::table('pages')->insert( $typi_pages );
        DB::table('page_translations')->insert( $typi_page_translations );

    }

}
