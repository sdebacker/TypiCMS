<?php

use TypiCMS\Models\User;

class TagSeeder extends Seeder {

	public function run()
	{
		$typi_tags = array(
			array('id' => '1','tag' => 'vêtement','slug' => 'vetement'),
			array('id' => '2','tag' => 'pied','slug' => 'pied'),
			array('id' => '3','tag' => 'semelle','slug' => 'semelle'),
			array('id' => '4','tag' => 'chaussette','slug' => 'chaussette'),
			array('id' => '5','tag' => 'neige','slug' => 'neige'),
			array('id' => '6','tag' => 'vehicule','slug' => 'vehicule'),
			array('id' => '7','tag' => 'hiver','slug' => 'hiver'),
			array('id' => '8','tag' => 'plante','slug' => 'plante'),
			array('id' => '9','tag' => 'azote','slug' => 'azote'),
			array('id' => '10','tag' => 'jeu','slug' => 'jeu'),
			array('id' => '11','tag' => 'été','slug' => 'ete'),
			array('id' => '12','tag' => 'plein-air','slug' => 'plein-air'),
			array('id' => '13','tag' => 'glissade','slug' => 'glissade'),
			array('id' => '14','tag' => 'pluie','slug' => 'pluie'),
			array('id' => '15','tag' => 'automne','slug' => 'automne'),
			array('id' => '16','tag' => 'printemps','slug' => 'printemps'),
			array('id' => '17','tag' => 'oiseau','slug' => 'oiseau'),
			array('id' => '18','tag' => 'hivers','slug' => 'hivers'),
			array('id' => '19','tag' => 'feuilles','slug' => 'feuilles'),
			array('id' => '20','tag' => 'jardin','slug' => 'jardin'),
			array('id' => '21','tag' => 'graine','slug' => 'graine'),
			array('id' => '22','tag' => 'pente','slug' => 'pente'),
			array('id' => '23','tag' => 'engrais','slug' => 'engrais')
		);

		$typi_projects_tags = array(
			array('id' => '1','project_id' => '11','tag_id' => '1','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
			array('id' => '2','project_id' => '11','tag_id' => '2','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
			array('id' => '3','project_id' => '11','tag_id' => '3','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
			array('id' => '4','project_id' => '11','tag_id' => '4','created_at' => '2014-02-27 11:58:56','updated_at' => '2014-02-27 11:58:56'),
			array('id' => '5','project_id' => '15','tag_id' => '5','created_at' => '2014-02-27 11:59:28','updated_at' => '2014-02-27 11:59:28'),
			array('id' => '6','project_id' => '15','tag_id' => '6','created_at' => '2014-02-27 11:59:28','updated_at' => '2014-02-27 11:59:28'),
			array('id' => '7','project_id' => '15','tag_id' => '7','created_at' => '2014-02-27 11:59:28','updated_at' => '2014-02-27 11:59:28'),
			array('id' => '8','project_id' => '17','tag_id' => '8','created_at' => '2014-02-27 11:59:42','updated_at' => '2014-02-27 11:59:42'),
			array('id' => '9','project_id' => '17','tag_id' => '9','created_at' => '2014-02-27 11:59:42','updated_at' => '2014-02-27 11:59:42'),
			array('id' => '10','project_id' => '9','tag_id' => '10','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
			array('id' => '11','project_id' => '9','tag_id' => '11','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
			array('id' => '12','project_id' => '9','tag_id' => '12','created_at' => '2014-02-27 11:59:58','updated_at' => '2014-02-27 11:59:58'),
			array('id' => '13','project_id' => '13','tag_id' => '5','created_at' => '2014-02-27 12:00:13','updated_at' => '2014-02-27 12:00:13'),
			array('id' => '14','project_id' => '13','tag_id' => '7','created_at' => '2014-02-27 12:00:13','updated_at' => '2014-02-27 12:00:13'),
			array('id' => '15','project_id' => '13','tag_id' => '13','created_at' => '2014-02-27 12:00:13','updated_at' => '2014-02-27 12:00:13'),
			array('id' => '16','project_id' => '12','tag_id' => '7','created_at' => '2014-02-27 12:00:26','updated_at' => '2014-02-27 12:00:26'),
			array('id' => '17','project_id' => '12','tag_id' => '14','created_at' => '2014-02-27 12:00:26','updated_at' => '2014-02-27 12:00:26'),
			array('id' => '18','project_id' => '12','tag_id' => '15','created_at' => '2014-02-27 12:00:26','updated_at' => '2014-02-27 12:00:26'),
			array('id' => '19','project_id' => '20','tag_id' => '11','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
			array('id' => '20','project_id' => '20','tag_id' => '15','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
			array('id' => '21','project_id' => '20','tag_id' => '16','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
			array('id' => '22','project_id' => '20','tag_id' => '17','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
			array('id' => '23','project_id' => '20','tag_id' => '18','created_at' => '2014-02-27 12:00:52','updated_at' => '2014-02-27 12:00:52'),
			array('id' => '24','project_id' => '10','tag_id' => '15','created_at' => '2014-02-27 12:01:08','updated_at' => '2014-02-27 12:01:08'),
			array('id' => '25','project_id' => '10','tag_id' => '19','created_at' => '2014-02-27 12:01:08','updated_at' => '2014-02-27 12:01:08'),
			array('id' => '26','project_id' => '10','tag_id' => '20','created_at' => '2014-02-27 12:01:08','updated_at' => '2014-02-27 12:01:08'),
			array('id' => '27','project_id' => '7','tag_id' => '1','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
			array('id' => '28','project_id' => '7','tag_id' => '2','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
			array('id' => '29','project_id' => '7','tag_id' => '11','created_at' => '2014-02-27 12:01:20','updated_at' => '2014-02-27 12:01:20'),
			array('id' => '30','project_id' => '19','tag_id' => '8','created_at' => '2014-02-27 12:01:34','updated_at' => '2014-02-27 12:01:34'),
			array('id' => '31','project_id' => '19','tag_id' => '16','created_at' => '2014-02-27 12:01:34','updated_at' => '2014-02-27 12:01:34'),
			array('id' => '32','project_id' => '19','tag_id' => '21','created_at' => '2014-02-27 12:01:34','updated_at' => '2014-02-27 12:01:34'),
			array('id' => '33','project_id' => '14','tag_id' => '5','created_at' => '2014-02-27 12:01:52','updated_at' => '2014-02-27 12:01:52'),
			array('id' => '34','project_id' => '14','tag_id' => '7','created_at' => '2014-02-27 12:01:52','updated_at' => '2014-02-27 12:01:52'),
			array('id' => '35','project_id' => '14','tag_id' => '13','created_at' => '2014-02-27 12:01:52','updated_at' => '2014-02-27 12:01:52'),
			array('id' => '36','project_id' => '14','tag_id' => '22','created_at' => '2014-02-27 12:01:52','updated_at' => '2014-02-27 12:01:52'),
			array('id' => '37','project_id' => '13','tag_id' => '22','created_at' => '2014-02-27 12:01:57','updated_at' => '2014-02-27 12:01:57'),
			array('id' => '38','project_id' => '18','tag_id' => '8','created_at' => '2014-02-27 12:02:11','updated_at' => '2014-02-27 12:02:11'),
			array('id' => '39','project_id' => '18','tag_id' => '16','created_at' => '2014-02-27 12:02:11','updated_at' => '2014-02-27 12:02:11'),
			array('id' => '40','project_id' => '18','tag_id' => '23','created_at' => '2014-02-27 12:02:11','updated_at' => '2014-02-27 12:02:11')
		);

		DB::table('tags')->insert( $typi_tags );
		DB::table('projects_tags')->insert( $typi_projects_tags );

	}

}