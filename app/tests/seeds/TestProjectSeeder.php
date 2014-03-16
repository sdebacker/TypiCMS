<?php

class TestProjectSeeder extends Seeder {

    public function run()
    {
        $typi_projects = array(
            array('id' => '7','category_id' => '1','created_at' => '2013-10-28 09:36:25','updated_at' => '2013-10-28 09:36:25'),
            array('id' => '8','category_id' => '1','created_at' => '2013-10-28 09:36:32','updated_at' => '2013-10-28 10:18:12'),
            array('id' => '9','category_id' => '1','created_at' => '2013-10-28 09:36:58','updated_at' => '2013-10-28 09:36:58'),
        );

        $typi_project_translations = array(
            array('id' => '19','project_id' => '7','locale' => 'fr','status' => '1','title' => 'Sandales','slug' => 'sandales','summary' => '','body' => '','created_at' => '2013-10-28 09:36:25','updated_at' => '2013-10-28 09:36:25'),
            array('id' => '20','project_id' => '7','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:25','updated_at' => '2013-10-28 09:36:25'),
            array('id' => '21','project_id' => '7','locale' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:25','updated_at' => '2013-10-28 09:36:25'),
            array('id' => '22','project_id' => '8','locale' => 'fr','status' => '0','title' => 'Cerf-volant','slug' => 'cerf-volant','summary' => '','body' => '','created_at' => '2013-10-28 09:36:32','updated_at' => '2013-10-28 10:18:12'),
            array('id' => '23','project_id' => '8','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:32','updated_at' => '2013-10-28 09:36:32'),
            array('id' => '24','project_id' => '8','locale' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:32','updated_at' => '2013-10-28 09:36:32'),
            array('id' => '25','project_id' => '9','locale' => 'fr','status' => '1','title' => 'Frisbee','slug' => 'frisbee','summary' => '','body' => '','created_at' => '2013-10-28 09:36:58','updated_at' => '2013-10-28 09:36:58'),
            array('id' => '26','project_id' => '9','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:58','updated_at' => '2013-10-28 09:36:58'),
            array('id' => '27','project_id' => '9','locale' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 09:36:58','updated_at' => '2013-10-28 09:36:58'),
        );

        DB::table('projects')->insert( $typi_projects );
        DB::table('project_translations')->insert( $typi_project_translations );

    }

}