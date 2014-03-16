<?php

class TestPlaceSeeder extends Seeder {

    public function run()
    {

        $typi_places = array(
            array('id'=>50,'title'=>'École Steiner','slug'=>'ecole-steiner','address'=>'Av. des Millepertuis, 14 - 1070 Bruxelles','email'=>'','phone'=>'02 521 04 92','fax'=>'','website'=>'http://www.steinerschoolbrussel.be','image'=>null,'logo'=>null,'latitude'=>50.8135045,'longitude'=>4.2838474,'created_at'=>'2014-01-19 15:29:19','updated_at'=>'2014-01-19 15:29:19'),
        );

        $typi_place_translations = array(
            array('id'=>113,'status'=>1,'place_id'=>50,'locale'=>'fr','info'=>'','created_at'=>'2014-01-19 15:29:19','updated_at'=>'2014-01-19 15:29:19'),
            array('id'=>114,'status'=>1,'place_id'=>50,'locale'=>'en','info'=>'','created_at'=>'2014-01-19 15:29:19','updated_at'=>'2014-01-19 15:29:19'),
        );

        DB::table('places')->insert( $typi_places );
        DB::table('place_translations')->insert( $typi_place_translations );

    }

}