<?php

class NewsSeeder extends Seeder
{
    public function run()
    {

        $typi_news = array(
            array('id' => '16','date' => '2014-09-22 13:15:00','created_at' => '2014-09-22 13:16:03','updated_at' => '2014-09-22 13:19:13'),
            array('id' => '17','date' => '2014-09-22 13:16:00','created_at' => '2014-09-22 13:16:12','updated_at' => '2014-09-22 13:21:34'),
            array('id' => '18','date' => '2014-09-22 13:17:00','created_at' => '2014-09-22 13:19:01','updated_at' => '2014-09-22 13:19:01'),
            array('id' => '19','date' => '2014-09-22 13:19:00','created_at' => '2014-09-22 13:20:01','updated_at' => '2014-09-22 13:20:01'),
            array('id' => '20','date' => '2014-09-22 13:20:00','created_at' => '2014-09-22 13:20:47','updated_at' => '2014-09-22 13:20:47'),
            array('id' => '21','date' => '2014-09-22 13:21:00','created_at' => '2014-09-22 13:22:48','updated_at' => '2014-09-22 13:22:48'),
            array('id' => '22','date' => '2014-09-22 13:22:00','created_at' => '2014-09-22 13:23:22','updated_at' => '2014-09-22 13:23:22'),
            array('id' => '23','date' => '2014-09-22 13:23:00','created_at' => '2014-09-22 13:24:20','updated_at' => '2014-09-22 13:24:20')
        );

        $typi_news_translations = array(
            array('id' => '1','news_id' => '16','locale' => 'fr','status' => '1','title' => 'Bootstrap 3.2','slug' => 'bootstrap-32','summary' => '','body' => '','created_at' => '2014-09-22 13:16:03','updated_at' => '2014-09-22 13:19:13'),
            array('id' => '2','news_id' => '16','locale' => 'nl','status' => '1','title' => 'Bootstrap 3.2','slug' => 'bootstrap-32','summary' => '','body' => '','created_at' => '2014-09-22 13:16:03','updated_at' => '2014-09-22 13:16:03'),
            array('id' => '3','news_id' => '16','locale' => 'en','status' => '1','title' => 'Bootstrap 3.2','slug' => 'bootstrap-32','summary' => '','body' => '','created_at' => '2014-09-22 13:16:03','updated_at' => '2014-09-22 13:19:13'),
            array('id' => '4','news_id' => '17','locale' => 'fr','status' => '1','title' => 'AngularJS bientôt dans TypiCMS','slug' => 'angularjs-dans-typicms','summary' => '','body' => '','created_at' => '2014-09-22 13:16:12','updated_at' => '2014-09-22 13:21:14'),
            array('id' => '5','news_id' => '17','locale' => 'nl','status' => '1','title' => 'AngularJS','slug' => 'agularjs','summary' => '','body' => '','created_at' => '2014-09-22 13:16:12','updated_at' => '2014-09-22 13:17:03'),
            array('id' => '6','news_id' => '17','locale' => 'en','status' => '1','title' => 'AngularJS will be part of TypiCMS','slug' => 'angularjs-in-typicms','summary' => '','body' => '','created_at' => '2014-09-22 13:16:12','updated_at' => '2014-09-22 13:21:34'),
            array('id' => '7','news_id' => '18','locale' => 'fr','status' => '1','title' => 'adamwathan/bootforms va remplacer Formbuilder','slug' => 'adamwathan-bootforms-va-remplacer-formbuilder','summary' => '','body' => '','created_at' => '2014-09-22 13:19:01','updated_at' => '2014-09-22 13:19:01'),
            array('id' => '8','news_id' => '18','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2014-09-22 13:19:01','updated_at' => '2014-09-22 13:19:01'),
            array('id' => '9','news_id' => '18','locale' => 'en','status' => '1','title' => 'Laravel Formbuilder will be replaced by adamwathan/bootforms','slug' => 'laravel-formbuilder-will-be-replaced-by-adamwathan-bootforms','summary' => '','body' => '','created_at' => '2014-09-22 13:19:01','updated_at' => '2014-09-22 13:19:01'),
            array('id' => '10','news_id' => '19','locale' => 'fr','status' => '1','title' => 'TypiCMS obtient la médaille de platine sur SensioLabsInsight','slug' => 'typicms-obtient-la-medaille-de-platine-sur-sensiolabsinsight','summary' => '','body' => '','created_at' => '2014-09-22 13:20:01','updated_at' => '2014-09-22 13:20:01'),
            array('id' => '11','news_id' => '19','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2014-09-22 13:20:01','updated_at' => '2014-09-22 13:20:01'),
            array('id' => '12','news_id' => '19','locale' => 'en','status' => '1','title' => 'TypiCMS has SensioLabsInsight Platinum Medal','slug' => 'typicms-has-sensiolabsinsight-platinum-medal','summary' => '','body' => '','created_at' => '2014-09-22 13:20:01','updated_at' => '2014-09-22 13:20:01'),
            array('id' => '13','news_id' => '20','locale' => 'fr','status' => '1','title' => 'autoprefixer','slug' => 'autoprefixer','summary' => '','body' => '','created_at' => '2014-09-22 13:20:47','updated_at' => '2014-09-22 13:20:47'),
            array('id' => '14','news_id' => '20','locale' => 'nl','status' => '1','title' => 'autoprefixer','slug' => 'autoprefixer','summary' => '','body' => '','created_at' => '2014-09-22 13:20:47','updated_at' => '2014-09-22 13:20:47'),
            array('id' => '15','news_id' => '20','locale' => 'en','status' => '1','title' => 'autoprefixer was added','slug' => 'autoprefixer-was-added','summary' => '','body' => '','created_at' => '2014-09-22 13:20:47','updated_at' => '2014-09-22 13:20:47'),
            array('id' => '16','news_id' => '21','locale' => 'fr','status' => '1','title' => 'TypiCMS peut générer un Sitemap xml','slug' => 'typicms-peut-generer-un-sitemap-xml','summary' => '','body' => '','created_at' => '2014-09-22 13:22:48','updated_at' => '2014-09-22 13:22:48'),
            array('id' => '17','news_id' => '21','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2014-09-22 13:22:48','updated_at' => '2014-09-22 13:22:48'),
            array('id' => '18','news_id' => '21','locale' => 'en','status' => '1','title' => 'TypiCMS can generate Sitemap xml','slug' => 'typicms-can-generate-sitemap-xml','summary' => '','body' => '','created_at' => '2014-09-22 13:22:48','updated_at' => '2014-09-22 13:22:48'),
            array('id' => '19','news_id' => '22','locale' => 'fr','status' => '1','title' => 'Une ressource hors ligne peut être prévisualisée','slug' => 'une-ressource-hors-ligne-peut-etre-previsualisee','summary' => '','body' => '','created_at' => '2014-09-22 13:23:22','updated_at' => '2014-09-22 13:23:22'),
            array('id' => '20','news_id' => '22','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2014-09-22 13:23:22','updated_at' => '2014-09-22 13:23:22'),
            array('id' => '21','news_id' => '22','locale' => 'en','status' => '1','title' => 'Preview button on edit form','slug' => 'preview-button-on-edit-form','summary' => '','body' => '','created_at' => '2014-09-22 13:23:22','updated_at' => '2014-09-22 13:23:22'),
            array('id' => '22','news_id' => '23','locale' => 'fr','status' => '1','title' => 'Des categories peuvent faire partie d\'un élément de menu','slug' => 'des-categories-peuvent-faire-partie-d-un-element-de-menu','summary' => '','body' => '','created_at' => '2014-09-22 13:24:20','updated_at' => '2014-09-22 13:24:20'),
            array('id' => '23','news_id' => '23','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2014-09-22 13:24:20','updated_at' => '2014-09-22 13:24:20'),
            array('id' => '24','news_id' => '23','locale' => 'en','status' => '1','title' => 'Categories can now be children of a menu item','slug' => 'categories-can-now-be-children-of-a-menu-item','summary' => '','body' => '','created_at' => '2014-09-22 13:24:20','updated_at' => '2014-09-22 13:24:20')
        );

        DB::table('news')->insert( $typi_news );
        DB::table('news_translations')->insert( $typi_news_translations );

    }

}
