<?php

class SentrySeeder extends Seeder
{
        public function run()
        {
                DB::table('users')->truncate();
                DB::table('groups')->truncate();
                DB::table('users_groups')->truncate();

                Sentry::getUserProvider()->create(array(
                        'email'       => 'admin@example.com',
                        'password'    => 'admin',
                        'first_name'  => 'Demo',
                        'last_name'   => 'User',
                        'permissions' => (array) json_decode('{"superuser":1}'),
                        'activated'   => 1,
                ));

                Sentry::getGroupProvider()->create(array(
                        'name'        => 'Admin',
                        'permissions' => (array) json_decode('{"dashboard":1,"admin.settings.index":1,"admin.pages.index":1,"admin.pages.view":1,"admin.pages.create":1,"admin.pages.store":1,"admin.pages.edit":1,"admin.pages.sort":1,"admin.pages.destroy":1,"admin.files.index":1,"admin.files.view":1,"admin.files.create":1,"admin.files.store":1,"admin.files.edit":1,"admin.files.sort":1,"admin.files.destroy":1,"admin.news.index":1,"admin.news.view":1,"admin.news.create":1,"admin.news.store":1,"admin.news.edit":1,"admin.news.sort":1,"admin.news.destroy":1,"admin.events.index":1,"admin.events.view":1,"admin.events.create":1,"admin.events.store":1,"admin.events.edit":1,"admin.events.sort":1,"admin.events.destroy":1,"admin.categories.index":1,"admin.categories.view":1,"admin.categories.create":1,"admin.categories.store":1,"admin.categories.edit":1,"admin.categories.sort":1,"admin.categories.destroy":1,"admin.projects.index":1,"admin.projects.view":1,"admin.projects.create":1,"admin.projects.store":1,"admin.projects.edit":1,"admin.projects.sort":1,"admin.projects.destroy":1,"admin.places.index":1,"admin.places.view":1,"admin.places.create":1,"admin.places.store":1,"admin.places.edit":1,"admin.places.sort":1,"admin.places.destroy":1,"admin.menus.index":1,"admin.menus.view":1,"admin.menus.create":1,"admin.menus.store":1,"admin.menus.edit":1,"admin.menus.sort":1,"admin.menus.destroy":1,"admin.menulinks.index":1,"admin.menulinks.view":1,"admin.menulinks.create":1,"admin.menulinks.store":1,"admin.menulinks.edit":1,"admin.menulinks.sort":1,"admin.menulinks.destroy":1,"admin.users.index":1,"admin.users.view":1,"admin.users.create":1,"admin.users.store":1,"admin.users.edit":1,"admin.users.sort":1,"admin.users.destroy":1,"admin.groups.index":1,"admin.groups.view":1,"admin.groups.create":1,"admin.groups.store":1,"admin.groups.edit":1,"admin.groups.sort":1,"admin.groups.destroy":1}'),
                ));
                Sentry::getGroupProvider()->create(array(
                        'name'        => 'Public',
                        'permissions' => array(),
                ));
                Sentry::getGroupProvider()->create(array(
                        'name'        => 'News',
                        'permissions' => (array) json_decode('{"dashboard":1,"admin.news.index":1,"admin.news.view":1,"admin.news.create":1,"admin.news.store":1,"admin.news.edit":1,"admin.news.sort":1,"admin.news.destroy":1}'),
                ));

                // Assign user permissions
                $adminUser    = Sentry::getUserProvider()->findByLogin('admin@example.com');
                $adminGroup = Sentry::getGroupProvider()->findByName('Admin');
                $adminUser->addGroup($adminGroup);
        }

}
