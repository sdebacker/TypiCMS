<?php

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('PageSeeder');
        $this->call('MenuSeeder');
        $this->call('SentrySeeder');
        $this->call('SettingsSeeder');
        $this->call('NewsSeeder');
        $this->call('CategorySeeder');
        $this->call('ProjectSeeder');
        $this->call('TagSeeder');
        $this->call('EventSeeder');
        $this->call('PlaceSeeder');
        $this->call('TranslationSeeder');
        $this->call('GallerySeeder');
        $this->call('BlockSeeder');
    }

}
