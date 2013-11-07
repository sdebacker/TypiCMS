<?php

use TypiCMS\Models\User;

class SentrySeeder extends Seeder {

    public function run()
    {
        DB::table('users')->truncate();
        DB::table('groups')->truncate();
        DB::table('users_groups')->truncate();

        Sentry::getUserProvider()->create(array(
            'email'         => 'info@typidesign.be',
            'password'      => 'admin',
            'first_name'    => 'Admin',
            'last_name'     => 'Nimda',

            'activated'   => 1,
        ));

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Admin',
            'permissions' => array('admin' => 1),
        ));

        // Assign user permissions
        $adminUser  = Sentry::getUserProvider()->findByLogin('info@typidesign.be');
        $adminGroup = Sentry::getGroupProvider()->findByName('Admin');
        $adminUser->addGroup($adminGroup);
    }

}