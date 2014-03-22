<?php

class SettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->truncate();

        $typi_settings = array(
            array('id' => '1','package' => NULL,'group_name' => 'config','key_name' => 'webmasterEmail','value' => 'info@example.com','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '2','package' => NULL,'group_name' => 'config','key_name' => 'typekitCode','value' => '','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2013-11-20 20:06:24'),
            array('id' => '3','package' => NULL,'group_name' => 'config','key_name' => 'googleAnalyticsCode','value' => '','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2013-11-20 20:06:24'),
            array('id' => '4','package' => NULL,'group_name' => 'config','key_name' => 'langChooser','value' => '1','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '5','package' => NULL,'group_name' => 'fr','key_name' => 'websiteTitle','value' => 'Site web sans titre','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '6','package' => NULL,'group_name' => 'fr','key_name' => 'status','value' => '1','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '7','package' => NULL,'group_name' => 'nl','key_name' => 'websiteTitle','value' => 'Untitled website','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '8','package' => NULL,'group_name' => 'nl','key_name' => 'status','value' => '1','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '9','package' => NULL,'group_name' => 'en','key_name' => 'websiteTitle','value' => 'Untitled website','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '10','package' => NULL,'group_name' => 'en','key_name' => 'status','value' => '1','type' => '','environment' => NULL,'created_at' => '2013-11-20 20:06:24','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '11','package' => NULL,'group_name' => 'config','key_name' => 'welcomeMessageURL','value' => '','type' => '','environment' => NULL,'created_at' => '2014-03-18 12:48:01','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '12','package' => NULL,'group_name' => 'config','key_name' => 'welcomeMessage','value' => 'Welcome to the administration panel.','type' => '','environment' => NULL,'created_at' => '2014-03-18 12:48:01','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '13','package' => NULL,'group_name' => 'config','key_name' => 'googleAnalyticsUniversalCode','value' => '','type' => '','environment' => NULL,'created_at' => '2014-03-18 12:48:01','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '14','package' => NULL,'group_name' => 'config','key_name' => 'authPublic','value' => NULL,'type' => '','environment' => NULL,'created_at' => '2014-03-18 12:48:01','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '15','package' => NULL,'group_name' => 'config','key_name' => 'register','value' => NULL,'type' => '','environment' => NULL,'created_at' => '2014-03-18 12:48:01','updated_at' => '2014-03-18 12:48:01'),
            array('id' => '16','package' => NULL,'group_name' => 'config','key_name' => 'adminLocale','value' => 'en','type' => '','environment' => NULL,'created_at' => '2014-03-22 12:48:01','updated_at' => '2014-03-22 12:48:01')
        );

        DB::table('settings')->insert( $typi_settings );

    }

}
