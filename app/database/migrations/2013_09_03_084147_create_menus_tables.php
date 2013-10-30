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
			$table->increments('id')->unsigned();
			$table->string('name');

			$table->timestamps();

		});
		Schema::create('menus_translations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('menu_id')->unsigned();

			$table->string('lang')->index();
			$table->tinyInteger('status');

			$table->string('title');

			$table->timestamps();
		});
		Schema::create('menulinks', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('menu_id')->unsigned();
			$table->integer('page_id')->unsigned();
			$table->integer('parent')->unsigned();
			$table->integer('position')->unsigned();
			$table->string('target', 10);
			$table->string('module_name', 50);
			$table->string('restricted_to');
			$table->string('class');
			$table->string('link_type', 20);

			$table->timestamps();

		});
		Schema::create('menulinks_translations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('menulink_id')->unsigned();

			$table->string('lang')->index();

			$table->tinyInteger('status');

			$table->string('title', 100);
			$table->string('url');
			$table->string('uri');

			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menus');
		Schema::drop('menus_translations');
		Schema::drop('menulinks');
		Schema::drop('menulinks_translations');
	}

}
