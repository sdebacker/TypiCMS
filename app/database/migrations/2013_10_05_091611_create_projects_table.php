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
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->timestamps();
		});

		Schema::create('project_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->integer('project_id')->unsigned();

			$table->string('locale')->index();

			$table->tinyInteger('status');

			$table->string('title');
			$table->string('slug')->nullable();

			$table->text('summary');
			$table->text('body');

			$table->timestamps();

			$table->unique(array('project_id', 'locale'));
			$table->foreign('project_id')->references('id')->on('projects');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('project_translations', function($table)
		{
			$table->dropForeign('project_translations_project_id_foreign');
		});
		Schema::drop('projects');
		Schema::drop('project_translations');
	}

}
