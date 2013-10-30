<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->timestamps();
		});
		Schema::create('posts_translations', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('post_id')->unsigned()->index();
			$table->string('title');
			$table->string('lang')->index();
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
		Schema::drop('posts');
		Schema::drop('posts_translations');
	}

}
