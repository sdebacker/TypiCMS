<?php

class TestTagSeeder extends Seeder {

    public function run()
    {
        $typi_tags = array(
            array('id' => '1','tag' => 'vêtement','slug' => 'vetement','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '2','tag' => 'pied','slug' => 'pied','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '10','tag' => 'jeu','slug' => 'jeu','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '11','tag' => 'été','slug' => 'ete','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
            array('id' => '12','tag' => 'plein-air','slug' => 'plein-air','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
        );

        $typi_taggables = array(
            array('id' => '10','tag_id' => '10','taggable_id' => '9','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
            array('id' => '11','tag_id' => '11','taggable_id' => '9','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
            array('id' => '12','tag_id' => '12','taggable_id' => '9','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
            array('id' => '27','tag_id' => '1','taggable_id' => '7','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
            array('id' => '28','tag_id' => '2','taggable_id' => '7','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
            array('id' => '29','tag_id' => '11','taggable_id' => '7','taggable_type' => 'TypiCMS\Modules\Projects\Models\Project','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
        );

        DB::table('tags')->insert( $typi_tags );
        DB::table('taggables')->insert( $typi_taggables );

    }

}