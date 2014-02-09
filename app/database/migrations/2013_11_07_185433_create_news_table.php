<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->timestamp('date');
			$table->timestamps();
		});

		Schema::create('news_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->integer('news_id')->unsigned();

			$table->string('locale')->index();

			$table->tinyInteger('status');

			$table->string('title');
			$table->string('slug')->nullable();
			
			$table->text('summary');
			$table->text('body');

			$table->timestamps();

			$table->unique(array('news_id', 'locale'));
			$table->foreign('news_id')->references('id')->on('news');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('news_translations', function($table)
		{
			$table->dropForeign('news_translations_news_id_foreign');
		});

		Schema::drop('news');
		Schema::drop('news_translations');
	}

}
