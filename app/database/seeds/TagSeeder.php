<?php

class TagSeeder extends Seeder
{
    public function run()
    {
        $typi_tags = array(
            array('id' => '1','tag' => 'vêtement','slug' => 'vetement','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '2','tag' => 'pied','slug' => 'pied','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '3','tag' => 'semelle','slug' => 'semelle','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '4','tag' => 'chaussette','slug' => 'chaussette','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '5','tag' => 'neige','slug' => 'neige','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '6','tag' => 'vehicule','slug' => 'vehicule','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '7','tag' => 'hiver','slug' => 'hiver','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '8','tag' => 'plante','slug' => 'plante','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '9','tag' => 'azote','slug' => 'azote','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '10','tag' => 'jeu','slug' => 'jeu','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '11','tag' => 'été','slug' => 'ete','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '12','tag' => 'plein-air','slug' => 'plein-air','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '13','tag' => 'glissade','slug' => 'glissade','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '14','tag' => 'pluie','slug' => 'pluie','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '15','tag' => 'automne','slug' => 'automne','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '16','tag' => 'printemps','slug' => 'printemps','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '17','tag' => 'oiseau','slug' => 'oiseau','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '18','tag' => 'hivers','slug' => 'hivers','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '19','tag' => 'feuilles','slug' => 'feuilles','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '20','tag' => 'jardin','slug' => 'jardin','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '21','tag' => 'graine','slug' => 'graine','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '22','tag' => 'pente','slug' => 'pente','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '23','tag' => 'engrais','slug' => 'engrais','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56')
        );

        $typi_taggables = array(
            array('id' => '1','tag_id' => '1','taggable_id' => '11','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '2','tag_id' => '2','taggable_id' => '11','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '3','tag_id' => '3','taggable_id' => '11','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '4','tag_id' => '4','taggable_id' => '11','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '5','tag_id' => '5','taggable_id' => '15','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:28','updated_at' => '2014-02-27 11:59:28'),
            array('id' => '6','tag_id' => '6','taggable_id' => '15','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:28','updated_at' => '2014-02-27 11:59:28'),
            array('id' => '7','tag_id' => '7','taggable_id' => '15','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:28','updated_at' => '2014-02-27 11:59:28'),
            array('id' => '8','tag_id' => '8','taggable_id' => '17','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:42','updated_at' => '2014-02-27 11:59:42'),
            array('id' => '9','tag_id' => '9','taggable_id' => '17','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:42','updated_at' => '2014-02-27 11:59:42'),
            array('id' => '10','tag_id' => '10','taggable_id' => '9','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
            array('id' => '11','tag_id' => '11','taggable_id' => '9','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
            array('id' => '12','tag_id' => '12','taggable_id' => '9','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
            array('id' => '13','tag_id' => '5','taggable_id' => '13','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:13','updated_at' => '2014-02-27 12:00:13'),
            array('id' => '14','tag_id' => '7','taggable_id' => '13','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:13','updated_at' => '2014-02-27 12:00:13'),
            array('id' => '15','tag_id' => '13','taggable_id' => '13','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:13','updated_at' => '2014-02-27 12:00:13'),
            array('id' => '16','tag_id' => '7','taggable_id' => '12','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:26','updated_at' => '2014-02-27 12:00:26'),
            array('id' => '17','tag_id' => '14','taggable_id' => '12','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:26','updated_at' => '2014-02-27 12:00:26'),
            array('id' => '18','tag_id' => '15','taggable_id' => '12','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:26','updated_at' => '2014-02-27 12:00:26'),
            array('id' => '19','tag_id' => '11','taggable_id' => '20','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
            array('id' => '20','tag_id' => '15','taggable_id' => '20','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
            array('id' => '21','tag_id' => '16','taggable_id' => '20','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
            array('id' => '22','tag_id' => '17','taggable_id' => '20','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
            array('id' => '23','tag_id' => '18','taggable_id' => '20','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
            array('id' => '24','tag_id' => '15','taggable_id' => '10','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:08','updated_at' => '2014-02-27 12:01:08'),
            array('id' => '25','tag_id' => '19','taggable_id' => '10','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:08','updated_at' => '2014-02-27 12:01:08'),
            array('id' => '26','tag_id' => '20','taggable_id' => '10','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:08','updated_at' => '2014-02-27 12:01:08'),
            array('id' => '27','tag_id' => '1','taggable_id' => '7','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
            array('id' => '28','tag_id' => '2','taggable_id' => '7','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
            array('id' => '29','tag_id' => '11','taggable_id' => '7','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
            array('id' => '30','tag_id' => '8','taggable_id' => '19','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:34','updated_at' => '2014-02-27 12:01:34'),
            array('id' => '31','tag_id' => '16','taggable_id' => '19','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:34','updated_at' => '2014-02-27 12:01:34'),
            array('id' => '32','tag_id' => '21','taggable_id' => '19','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:34','updated_at' => '2014-02-27 12:01:34'),
            array('id' => '33','tag_id' => '5','taggable_id' => '14','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:52','updated_at' => '2014-02-27 12:01:52'),
            array('id' => '34','tag_id' => '7','taggable_id' => '14','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:52','updated_at' => '2014-02-27 12:01:52'),
            array('id' => '35','tag_id' => '13','taggable_id' => '14','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:52','updated_at' => '2014-02-27 12:01:52'),
            array('id' => '36','tag_id' => '22','taggable_id' => '14','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:52','updated_at' => '2014-02-27 12:01:52'),
            array('id' => '37','tag_id' => '22','taggable_id' => '13','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:57','updated_at' => '2014-02-27 12:01:57'),
            array('id' => '38','tag_id' => '8','taggable_id' => '18','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:02:11','updated_at' => '2014-02-27 12:02:11'),
            array('id' => '39','tag_id' => '16','taggable_id' => '18','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:02:11','updated_at' => '2014-02-27 12:02:11'),
            array('id' => '40','tag_id' => '23','taggable_id' => '18','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:02:11','updated_at' => '2014-02-27 12:02:11')
        );

        DB::table('tags')->insert( $typi_tags );
        DB::table('taggables')->insert( $typi_taggables );

    }

}
