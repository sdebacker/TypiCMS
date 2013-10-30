<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('meta_robots_no_index');
			$table->string('meta_robots_no_follow');

			$table->integer('position')->unsigned();
			$table->integer('parent')->unsigned();

			$table->tinyInteger('rss_enabled');
			$table->tinyInteger('comments_enabled');
			$table->tinyInteger('is_home');

			$table->text('css');
			$table->text('js');

			$table->string('template');

			$table->timestamps();

		});

		Schema::create('pages_translations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('page_id')->unsigned();

			$table->string('lang')->index();

			$table->string('slug');
			$table->string('uri')->unique()->nullable();

			$table->string('title');
			$table->text('body');

			$table->tinyInteger('status');

			$table->string('meta_title');
			$table->string('meta_keywords');
			$table->string('meta_description');

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
		Schema::drop('pages');
		Schema::drop('pages_translations');
	}

}
