<?php

class TestSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('TestPageSeeder'); // needed for tests
        $this->call('TestMenuSeeder'); // needed for tests
        $this->call('TestSentrySeeder');
        $this->call('TestSettingsSeeder');
        $this->call('TestNewsSeeder');
        $this->call('TestCategorySeeder');
        $this->call('TestProjectSeeder');
        $this->call('TestTagSeeder');
        $this->call('TestEventSeeder');
        $this->call('TestPlaceSeeder');
        $this->call('TestTranslationSeeder');
    }

}