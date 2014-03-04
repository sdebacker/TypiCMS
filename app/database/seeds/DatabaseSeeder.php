<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('PageSeeder'); // needed for tests
		$this->call('MenuSeeder'); // needed for tests
		$this->call('SentrySeeder');
		$this->call('SettingsSeeder');
		$this->call('NewsSeeder');
		$this->call('CategorySeeder');
		$this->call('ProjectSeeder');
		$this->call('TagSeeder');
		$this->call('EventSeeder');
		$this->call('PlaceSeeder');
		$this->call('TranslationSeeder');
	}

}