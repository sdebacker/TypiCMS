<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->timestamps();
		});

		Schema::create('projects_translations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('project_id')->unsigned();

			$table->string('lang')->index();

			$table->tinyInteger('status');

			$table->string('title');
			$table->string('slug')->nullable();

			$table->text('summary');
			$table->text('body');

			$table->timestamps();

			$table->unique(array('lang', 'slug'));
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
		Schema::drop('projects_translations');
	}

}
