<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
		});

		Schema::create('categories_translations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('category_id')->unsigned();
			
			$table->integer('position')->unsigned();

			$table->string('lang')->index();

			$table->tinyInteger('status');

			$table->string('title');
			$table->string('slug')->nullable();

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
		Schema::drop('categories');
		Schema::drop('categories_translations');
	}

}
