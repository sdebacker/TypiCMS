<?php

use TypiCMS\Models\User;

class EventSeeder extends Seeder {

	public function run()
	{
		DB::table('events')->delete();
		DB::table('events_translations')->delete();

		$typi_events = array(
		  array('id' => '1','start_date' => '2013-10-24','end_date' => '0000-00-00','start_time' => ' 20:30','end_time' => '','created_at' => '2013-10-28 23:20:14','updated_at' => '2013-10-28 23:20:14'),
		  array('id' => '2','start_date' => '2013-11-16','end_date' => '0000-00-00','start_time' => ' 20:00','end_time' => '','created_at' => '2013-10-28 23:21:10','updated_at' => '2013-10-28 23:21:10'),
		  array('id' => '3','start_date' => '2013-12-20','end_date' => '2014-01-09','start_time' => '','end_time' => '','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37')
		);

		$typi_events_translations = array(
		  array('id' => '1','event_id' => '1','lang' => 'fr','status' => '1','title' => 'Concert à la maison','slug' => 'concert-a-la-maison','summary' => '','body' => '','created_at' => '2013-10-28 23:20:14','updated_at' => '2013-10-28 23:20:14'),
		  array('id' => '2','event_id' => '1','lang' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 23:20:14','updated_at' => '2013-10-28 23:20:14'),
		  array('id' => '3','event_id' => '1','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 23:20:14','updated_at' => '2013-10-28 23:20:14'),
		  array('id' => '4','event_id' => '2','lang' => 'fr','status' => '1','title' => 'Cabaret Boite à Clous','slug' => 'cabaret-boite-a-clous','summary' => '','body' => '','created_at' => '2013-10-28 23:21:10','updated_at' => '2013-10-28 23:21:10'),
		  array('id' => '5','event_id' => '2','lang' => 'nl','status' => '1','title' => 'Boite à Clous Cabaret','slug' => 'boite-a-clous-cabaret','summary' => '','body' => '','created_at' => '2013-10-28 23:21:10','updated_at' => '2013-10-28 23:21:10'),
		  array('id' => '6','event_id' => '2','lang' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 23:21:10','updated_at' => '2013-10-28 23:21:10'),
		  array('id' => '7','event_id' => '3','lang' => 'fr','status' => '1','title' => 'Vacances d’hiver','slug' => 'vacances-dhiver','summary' => '','body' => '','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37'),
		  array('id' => '8','event_id' => '3','lang' => 'nl','status' => '0','title' => 'Vacancies','slug' => 'vacancies','summary' => '','body' => '','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37'),
		  array('id' => '9','event_id' => '3','lang' => 'en','status' => '1','title' => 'Holidays','slug' => 'holidays','summary' => '','body' => '','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37')
		);

		DB::table('events')->insert( $typi_events );
		DB::table('events_translations')->insert( $typi_events_translations );

	}

}