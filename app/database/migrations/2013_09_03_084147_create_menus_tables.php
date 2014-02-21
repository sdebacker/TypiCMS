<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('class')->nullable();

			$table->timestamps();

		});
		Schema::create('menu_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->integer('menu_id')->unsigned();

			$table->string('locale')->index();
			$table->tinyInteger('status');

			$table->string('title');

			$table->timestamps();

			$table->unique(array('menu_id', 'locale'));
			$table->foreign('menu_id')->references('id')->on('menus');

		});
		Schema::create('menulinks', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->integer('menu_id')->unsigned();
			$table->integer('page_id')->unsigned()->nullable();
			$table->integer('parent')->unsigned()->default(0);
			$table->integer('position')->unsigned()->default(0);
			$table->string('target', 10)->nullable();
			$table->string('module_name', 50)->nullable();
			$table->string('restricted_to')->nullable();
			$table->string('class')->nullable();
			$table->string('link_type', 20)->nullable();

			$table->timestamps();

		});
		Schema::create('menulink_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->integer('menulink_id')->unsigned();

			$table->string('locale')->index();

			$table->tinyInteger('status');

			$table->string('title', 100);
			$table->string('url');
			$table->string('uri');

			$table->timestamps();

			$table->unique(array('menulink_id', 'locale'));
			$table->foreign('menulink_id')->references('id')->on('menulinks');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('menu_translations', function($table)
		{
			$table->dropForeign('menu_translations_menu_id_foreign');
		});
		Schema::table('menulink_translations', function($table)
		{
			$table->dropForeign('menulink_translations_menulink_id_foreign');
		});
		Schema::drop('menus');
		Schema::drop('menu_translations');
		Schema::drop('menulinks');
		Schema::drop('menulink_translations');
	}

}
