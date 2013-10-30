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

		$this->call('SentrySeeder');
		$this->command->info('Sentry tables seeded.');
		$this->call('PageSeeder');
		$this->command->info('Pages seeded.');
		$this->call('MenuSeeder');
		$this->command->info('Menus seeded.');
		$this->call('CategorySeeder');
		$this->command->info('Categories seeded.');
		$this->call('ProjectSeeder');
		$this->command->info('Projects seeded.');
		$this->call('EventSeeder');
		$this->command->info('Events seeded.');
	}

}