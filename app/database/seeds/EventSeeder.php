<?php

class EventSeeder extends Seeder
{
    public function run()
    {

        $typi_events = array(
            array('id' => '1','start_date' => '2014-10-24 00:00:00','end_date' => '2014-10-24 00:00:00','created_at' => '2013-10-28 23:20:14','updated_at' => '2013-10-28 23:20:14'),
            array('id' => '2','start_date' => '2014-11-16 08:00:00','end_date' => '2014-11-18 18:30:00','created_at' => '2013-10-28 23:21:10','updated_at' => '2013-10-28 23:21:10'),
            array('id' => '3','start_date' => '2014-05-20 22:00:00','end_date' => '2014-08-09 10:30:00','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37'),
            array('id' => '4','start_date' => '2014-12-20 10:00:00','end_date' => '2015-01-09 18:30:00','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37')
        );

        $typi_event_translations = array(
            array('id' => '1','event_id' => '1','locale' => 'fr','status' => '1','title' => 'Evenement 4','slug' => 'evenement-4','summary' => '','body' => '','created_at' => '2013-10-28 23:20:14','updated_at' => '2013-10-28 23:20:14'),
            array('id' => '2','event_id' => '1','locale' => 'nl','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 23:20:14','updated_at' => '2013-10-28 23:20:14'),
            array('id' => '3','event_id' => '1','locale' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 23:20:14','updated_at' => '2013-10-28 23:20:14'),
            array('id' => '4','event_id' => '2','locale' => 'fr','status' => '1','title' => 'Evenement 1','slug' => 'evenement-1','summary' => '','body' => '','created_at' => '2013-10-28 23:21:10','updated_at' => '2013-10-28 23:21:10'),
            array('id' => '5','event_id' => '2','locale' => 'nl','status' => '1','title' => 'Event 1','slug' => 'event-1','summary' => '','body' => '','created_at' => '2013-10-28 23:21:10','updated_at' => '2013-10-28 23:21:10'),
            array('id' => '6','event_id' => '2','locale' => 'en','status' => '0','title' => '','slug' => NULL,'summary' => '','body' => '','created_at' => '2013-10-28 23:21:10','updated_at' => '2013-10-28 23:21:10'),
            array('id' => '7','event_id' => '3','locale' => 'fr','status' => '1','title' => 'Evenement 2','slug' => 'evenement-2','summary' => '','body' => '','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37'),
            array('id' => '8','event_id' => '3','locale' => 'nl','status' => '0','title' => 'Event 2','slug' => 'event-2','summary' => '','body' => '','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37'),
            array('id' => '9','event_id' => '3','locale' => 'en','status' => '1','title' => 'Event 2','slug' => 'event-2','summary' => '','body' => '','created_at' => '2013-10-28 23:22:37','updated_at' => '2013-10-28 23:22:37'),
            array('id' => '10','event_id' => '4','locale' => 'fr','status' => '1','title' => 'Evenement 3','slug' => 'evenement-3','summary' => '','body' => '','created_at' => '2014-03-28 23:22:37','updated_at' => '2014-03-28 23:22:37'),
            array('id' => '11','event_id' => '4','locale' => 'nl','status' => '0','title' => 'Event 3','slug' => 'event-3','summary' => '','body' => '','created_at' => '2014-03-28 23:22:37','updated_at' => '2014-03-28 23:22:37'),
            array('id' => '12','event_id' => '4','locale' => 'en','status' => '1','title' => 'Event 3','slug' => 'event-3','summary' => '','body' => '','created_at' => '2014-03-28 23:22:37','updated_at' => '2014-03-28 23:22:37')
        );

        DB::table('events')->insert( $typi_events );
        DB::table('event_translations')->insert( $typi_event_translations );

    }

}
