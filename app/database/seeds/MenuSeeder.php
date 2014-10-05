<?php

class MenuSeeder extends Seeder
{
    public function run()
    {

        $typi_menulinks = array(
            array('id' => '1','menu_id' => '1','page_id' => '1','parent' => '0','position' => '1','target' => '','module_name' => '','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2013-09-03 22:08:05','updated_at' => '2014-02-04 18:58:25'),
            array('id' => '2','menu_id' => '1','page_id' => '0','parent' => '0','position' => '8','target' => '','module_name' => 'contacts','class' => 'menu-contact','icon_class' => NULL,'has_categories' => 0,'created_at' => '2013-09-03 22:08:35','updated_at' => '2014-03-28 13:32:30'),
            array('id' => '16','menu_id' => '1','page_id' => '29','parent' => '0','position' => '2','target' => '','module_name' => 'poi','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2013-09-09 23:18:49','updated_at' => '2014-02-04 18:58:25'),
            array('id' => '17','menu_id' => '1','page_id' => '0','parent' => '0','position' => '3','target' => '','module_name' => 'events','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2013-10-05 19:30:30','updated_at' => '2014-02-04 18:58:25'),
            array('id' => '18','menu_id' => '1','page_id' => '0','parent' => '0','position' => '5','target' => '','module_name' => 'projects','class' => '','icon_class' => NULL,'has_categories' => 1,'created_at' => '2013-10-05 19:31:09','updated_at' => '2014-02-04 18:58:25'),
            array('id' => '19','menu_id' => '2','page_id' => '0','parent' => '0','position' => '2','target' => '','module_name' => 'contacts','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2013-11-02 17:20:16','updated_at' => '2014-03-28 13:32:46'),
            array('id' => '20','menu_id' => '2','page_id' => '1','parent' => '0','position' => '1','target' => '','module_name' => '','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2013-11-02 17:20:43','updated_at' => '2013-11-02 17:31:37'),
            array('id' => '21','menu_id' => '1','page_id' => '0','parent' => '0','position' => '4','target' => '','module_name' => 'news','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2013-11-08 11:14:39','updated_at' => '2014-02-04 18:58:25'),
            array('id' => '22','menu_id' => '3','page_id' => '0','parent' => '0','position' => '0','target' => '_blank','module_name' => '','class' => 'btn-facebook','icon_class' => 'fa fa-facebook fa-fw','has_categories' => 0,'created_at' => '2014-02-04 18:30:11','updated_at' => '2014-02-04 18:30:17'),
            array('id' => '23','menu_id' => '3','page_id' => '0','parent' => '0','position' => '0','target' => '_blank','module_name' => '','class' => 'btn-twitter','icon_class' => 'fa fa-twitter fa-fw','has_categories' => 0,'created_at' => '2014-02-04 18:31:35','updated_at' => '2014-02-04 18:31:47'),
            array('id' => '24','menu_id' => '1','page_id' => '0','parent' => '0','position' => '7','target' => '','module_name' => 'places','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2014-02-04 18:58:20','updated_at' => '2014-02-04 18:59:32'),
            array('id' => '25','menu_id' => '1','page_id' => '0','parent' => '0','position' => '6','target' => '','module_name' => 'galleries','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2014-05-09 15:50:51','updated_at' => '2014-05-09 15:50:51'),
            array('id' => '26','menu_id' => '2','page_id' => '0','parent' => '0','position' => '3','target' => '','module_name' => 'partners','class' => '','icon_class' => NULL,'has_categories' => 0,'created_at' => '2014-05-09 15:50:51','updated_at' => '2014-05-09 15:50:51'),
        );

        $typi_menulink_translations = array(
            array('id' => '1','menulink_id' => '1','locale' => 'fr','status' => '1','title' => 'Accueil','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '2','menulink_id' => '1','locale' => 'nl','status' => '1','title' => 'Home','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '3','menulink_id' => '1','locale' => 'en','status' => '1','title' => 'Home','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '4','menulink_id' => '2','locale' => 'fr','status' => '1','title' => 'Contact','url' => '','uri' => 'fr/contact','created_at' => '0000-00-00 00:00:00','updated_at' => '2014-03-28 13:29:27'),
            array('id' => '5','menulink_id' => '2','locale' => 'nl','status' => '1','title' => 'Contact','url' => '','uri' => 'nl/contact','created_at' => '0000-00-00 00:00:00','updated_at' => '2014-03-28 13:29:27'),
            array('id' => '6','menulink_id' => '2','locale' => 'en','status' => '1','title' => 'Contact','url' => '','uri' => 'en/contact','created_at' => '0000-00-00 00:00:00','updated_at' => '2014-03-28 13:29:27'),
            array('id' => '46','menulink_id' => '16','locale' => 'fr','status' => '1','title' => 'Infos','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '47','menulink_id' => '16','locale' => 'nl','status' => '1','title' => 'Info','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '48','menulink_id' => '16','locale' => 'en','status' => '1','title' => 'Info','url' => '','uri' => '','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '49','menulink_id' => '17','locale' => 'fr','status' => '1','title' => 'Événements','url' => '','uri' => 'fr/evenements','created_at' => '2013-10-05 19:30:30','updated_at' => '2013-10-05 19:30:32'),
            array('id' => '50','menulink_id' => '17','locale' => 'nl','status' => '1','title' => 'Evenementen','url' => '','uri' => 'nl/evenementen','created_at' => '2013-10-05 19:30:30','updated_at' => '2013-10-05 19:31:48'),
            array('id' => '51','menulink_id' => '17','locale' => 'en','status' => '1','title' => 'Events','url' => '','uri' => 'en/events','created_at' => '2013-10-05 19:30:30','updated_at' => '2013-10-05 19:31:51'),
            array('id' => '52','menulink_id' => '18','locale' => 'fr','status' => '1','title' => 'Projets','url' => '','uri' => 'fr/projets','created_at' => '2013-10-05 19:31:09','updated_at' => '2013-10-05 19:31:11'),
            array('id' => '53','menulink_id' => '18','locale' => 'nl','status' => '1','title' => 'Projecten','url' => '','uri' => 'nl/projecten','created_at' => '2013-10-05 19:31:09','updated_at' => '2013-10-05 19:31:49'),
            array('id' => '54','menulink_id' => '18','locale' => 'en','status' => '1','title' => 'Projects','url' => '','uri' => 'en/projects','created_at' => '2013-10-05 19:31:09','updated_at' => '2013-10-05 19:31:51'),
            array('id' => '55','menulink_id' => '19','locale' => 'fr','status' => '1','title' => 'Contact','url' => '','uri' => 'fr/contact','created_at' => '2013-11-02 17:20:16','updated_at' => '2014-03-28 13:30:40'),
            array('id' => '56','menulink_id' => '19','locale' => 'nl','status' => '1','title' => 'Contact','url' => '','uri' => 'nl/contact','created_at' => '2013-11-02 17:20:16','updated_at' => '2014-03-28 13:30:40'),
            array('id' => '57','menulink_id' => '19','locale' => 'en','status' => '1','title' => 'Contact','url' => '','uri' => 'en/contact','created_at' => '2013-11-02 17:20:16','updated_at' => '2014-03-28 13:30:40'),
            array('id' => '58','menulink_id' => '20','locale' => 'fr','status' => '1','title' => 'Accueil','url' => '','uri' => '','created_at' => '2013-11-02 17:20:43','updated_at' => '2013-11-02 17:20:51'),
            array('id' => '59','menulink_id' => '20','locale' => 'nl','status' => '1','title' => 'Home','url' => '','uri' => '','created_at' => '2013-11-02 17:20:43','updated_at' => '2013-11-02 17:20:47'),
            array('id' => '60','menulink_id' => '20','locale' => 'en','status' => '1','title' => 'Home','url' => '','uri' => '','created_at' => '2013-11-02 17:20:43','updated_at' => '2013-11-02 17:20:44'),
            array('id' => '61','menulink_id' => '21','locale' => 'fr','status' => '1','title' => 'Actualités','url' => '','uri' => 'fr/actualites','created_at' => '2013-11-08 11:14:39','updated_at' => '2013-11-08 11:14:39'),
            array('id' => '62','menulink_id' => '21','locale' => 'nl','status' => '1','title' => 'Nieuws','url' => '','uri' => 'nl/nieuws','created_at' => '2013-11-08 11:14:39','updated_at' => '2013-11-08 11:14:39'),
            array('id' => '63','menulink_id' => '21','locale' => 'en','status' => '1','title' => 'News','url' => '','uri' => 'en/news','created_at' => '2013-11-08 11:14:39','updated_at' => '2013-11-08 11:14:39'),
            array('id' => '64','menulink_id' => '22','locale' => 'fr','status' => '1','title' => 'Facebook','url' => 'https://www.facebook.com/pages/Typi-Design/101975113206089','uri' => '','created_at' => '2014-02-04 18:30:11','updated_at' => '2014-02-04 18:30:17'),
            array('id' => '65','menulink_id' => '22','locale' => 'nl','status' => '1','title' => 'Facebook','url' => 'https://www.facebook.com/pages/Typi-Design/101975113206089','uri' => '','created_at' => '2014-02-04 18:30:11','updated_at' => '2014-02-04 18:30:17'),
            array('id' => '66','menulink_id' => '22','locale' => 'en','status' => '1','title' => 'Facebook','url' => 'https://www.facebook.com/pages/Typi-Design/101975113206089','uri' => '','created_at' => '2014-02-04 18:30:11','updated_at' => '2014-02-04 18:30:17'),
            array('id' => '67','menulink_id' => '23','locale' => 'fr','status' => '1','title' => 'Twitter','url' => 'https://twitter.com/TypiDesign','uri' => '','created_at' => '2014-02-04 18:31:35','updated_at' => '2014-02-04 18:31:47'),
            array('id' => '68','menulink_id' => '23','locale' => 'nl','status' => '1','title' => 'Twitter','url' => 'https://twitter.com/TypiDesign','uri' => '','created_at' => '2014-02-04 18:31:35','updated_at' => '2014-02-04 18:31:44'),
            array('id' => '69','menulink_id' => '23','locale' => 'en','status' => '1','title' => 'Twitter','url' => 'https://twitter.com/TypiDesign','uri' => '','created_at' => '2014-02-04 18:31:35','updated_at' => '2014-02-04 18:31:42'),
            array('id' => '70','menulink_id' => '24','locale' => 'fr','status' => '1','title' => 'Adresses','url' => '','uri' => 'fr/adresses','created_at' => '2014-02-04 18:58:20','updated_at' => '2014-02-04 18:59:32'),
            array('id' => '71','menulink_id' => '24','locale' => 'nl','status' => '1','title' => 'Adres','url' => '','uri' => 'nl/adres','created_at' => '2014-02-04 18:58:20','updated_at' => '2014-02-04 18:59:32'),
            array('id' => '72','menulink_id' => '24','locale' => 'en','status' => '1','title' => 'Addresses','url' => '','uri' => 'en/addresses','created_at' => '2014-02-04 18:58:20','updated_at' => '2014-02-04 18:59:32'),
            array('id' => '73','menulink_id' => '25','locale' => 'fr','status' => '1','title' => 'Galeries','url' => '','uri' => 'fr/galeries','created_at' => '2014-05-09 15:50:51','updated_at' => '2014-05-09 15:51:03'),
            array('id' => '74','menulink_id' => '25','locale' => 'nl','status' => '1','title' => 'Galeries','url' => '','uri' => 'nl/galeries','created_at' => '2014-05-09 15:50:51','updated_at' => '2014-05-09 15:51:05'),
            array('id' => '75','menulink_id' => '25','locale' => 'en','status' => '1','title' => 'Galleries','url' => '','uri' => 'en/galleries','created_at' => '2014-05-09 15:50:51','updated_at' => '2014-05-09 15:50:51'),
            array('id' => '76','menulink_id' => '26','locale' => 'fr','status' => '1','title' => 'Partenaires','url' => '','uri' => 'fr/partenaires','created_at' => '2014-06-18 15:50:51','updated_at' => '2014-06-18 15:51:03'),
            array('id' => '77','menulink_id' => '26','locale' => 'nl','status' => '1','title' => 'Partners','url' => '','uri' => 'nl/partners','created_at' => '2014-06-18 15:50:51','updated_at' => '2014-06-18 15:51:05'),
            array('id' => '78','menulink_id' => '26','locale' => 'en','status' => '1','title' => 'Partners','url' => '','uri' => 'en/partners','created_at' => '2014-06-18 15:50:51','updated_at' => '2014-06-18 15:50:51'),
        );

        // `typicms`.`typi_menus`
        $typi_menus = array(
            array('id' => '1','name' => 'main','class' => 'nav-main nav nav-pills','created_at' => '2013-09-03 22:05:21','updated_at' => '2014-02-17 16:25:05'),
            array('id' => '2','name' => 'footer','class' => 'nav-footer nav nav-pills pull-right','created_at' => '2013-09-03 22:05:42','updated_at' => '2014-02-17 16:24:59'),
            array('id' => '3','name' => 'social','class' => 'nav-social list-unstyled','created_at' => '2014-02-04 18:27:18','updated_at' => '2014-02-17 16:25:21'),
        );

        // `typicms`.`typi_menu_translations`
        $typi_menu_translations = array(
            array('id' => '1','menu_id' => '1','locale' => 'fr','status' => '1','title' => 'Principal','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '2','menu_id' => '1','locale' => 'nl','status' => '1','title' => 'Main','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '3','menu_id' => '1','locale' => 'en','status' => '1','title' => 'Main','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '4','menu_id' => '2','locale' => 'fr','status' => '1','title' => 'Pied de site','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '5','menu_id' => '2','locale' => 'nl','status' => '1','title' => 'Footer','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '6','menu_id' => '2','locale' => 'en','status' => '1','title' => 'Footer','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('id' => '7','menu_id' => '3','locale' => 'fr','status' => '1','title' => 'Réseaux sociaux','created_at' => '2014-02-04 18:27:18','updated_at' => '2014-02-04 18:35:01'),
            array('id' => '8','menu_id' => '3','locale' => 'nl','status' => '1','title' => 'Sociale netwerken','created_at' => '2014-02-04 18:27:18','updated_at' => '2014-02-04 18:35:01'),
            array('id' => '9','menu_id' => '3','locale' => 'en','status' => '1','title' => 'Social networks','created_at' => '2014-02-04 18:27:18','updated_at' => '2014-02-04 18:35:01'),
        );

        DB::table('menus')->insert( $typi_menus );
        DB::table('menu_translations')->insert( $typi_menu_translations );
        DB::table('menulinks')->insert( $typi_menulinks );
        DB::table('menulink_translations')->insert( $typi_menulink_translations );

    }

}
