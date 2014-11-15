<?php

class SentrySeeder extends Seeder
{
    public function run()
    {
        $typi_groups = array(
            array('id' => '1','name' => 'Admin','permissions' => '{"dashboard":1,"admin.settings.index":1,"admin.pages.index":1,"admin.pages.view":1,"admin.pages.create":1,"admin.pages.store":1,"admin.pages.edit":1,"admin.pages.sort":1,"admin.pages.destroy":1,"admin.files.index":1,"admin.files.view":1,"admin.files.create":1,"admin.files.store":1,"admin.files.edit":1,"admin.files.sort":1,"admin.files.destroy":1,"admin.news.index":1,"admin.news.view":1,"admin.news.create":1,"admin.news.store":1,"admin.news.edit":1,"admin.news.sort":1,"admin.news.destroy":1,"admin.events.index":1,"admin.events.view":1,"admin.events.create":1,"admin.events.store":1,"admin.events.edit":1,"admin.events.sort":1,"admin.events.destroy":1,"admin.categories.index":1,"admin.categories.view":1,"admin.categories.create":1,"admin.categories.store":1,"admin.categories.edit":1,"admin.categories.sort":1,"admin.categories.destroy":1,"admin.projects.index":1,"admin.projects.view":1,"admin.projects.create":1,"admin.projects.store":1,"admin.projects.edit":1,"admin.projects.sort":1,"admin.projects.destroy":1,"admin.places.index":1,"admin.places.view":1,"admin.places.create":1,"admin.places.store":1,"admin.places.edit":1,"admin.places.sort":1,"admin.places.destroy":1,"admin.menus.index":1,"admin.menus.view":1,"admin.menus.create":1,"admin.menus.store":1,"admin.menus.edit":1,"admin.menus.sort":1,"admin.menus.destroy":1,"admin.menulinks.index":1,"admin.menulinks.view":1,"admin.menulinks.create":1,"admin.menulinks.store":1,"admin.menulinks.edit":1,"admin.menulinks.sort":1,"admin.menulinks.destroy":1,"admin.users.index":1,"admin.users.view":1,"admin.users.create":1,"admin.users.store":1,"admin.users.edit":1,"admin.users.sort":1,"admin.users.destroy":1,"admin.groups.index":1,"admin.groups.view":1,"admin.groups.create":1,"admin.groups.store":1,"admin.groups.edit":1,"admin.groups.sort":1,"admin.groups.destroy":1}','created_at' => '2014-11-04 23:30:06','updated_at' => '2014-11-04 23:30:06'),
            array('id' => '2','name' => 'Public','permissions' => '','created_at' => '2014-11-04 23:30:06','updated_at' => '2014-11-04 23:30:06'),
            array('id' => '3','name' => 'News','permissions' => '{"dashboard":1,"admin.news.index":1,"admin.news.view":1,"admin.news.create":1,"admin.news.store":1,"admin.news.edit":1,"admin.news.sort":1,"admin.news.destroy":1}','created_at' => '2014-11-04 23:30:06','updated_at' => '2014-11-04 23:30:06')
        );

        $typi_users = array(
            array('id' => '1','email' => 'admin@example.com','password' => '$2y$08$qCcZxMo8m5SZ0OR3l0BnsOYqViK1LoXOP2tmy4mUT9oqsQP/Dm2w.','permissions' => '{"superuser":1}','activated' => '1','activation_code' => NULL,'activated_at' => NULL,'last_login' => NULL,'persist_code' => NULL,'reset_password_code' => NULL,'first_name' => 'Demo','last_name' => 'User','preferences' => NULL,'created_at' => '2014-11-04 23:30:06','updated_at' => '2014-11-04 23:30:06')
        );

        $typi_users_groups = array(
            array('user_id' => '1','group_id' => '1')
        );
        DB::table('users')->insert( $typi_users );
        DB::table('groups')->insert( $typi_groups );
        DB::table('users_groups')->insert( $typi_users_groups );
    }

}
