<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');

			$table->date('start_date');
			$table->date('end_date')->nullable();
			$table->string('start_time')->nullable();
			$table->string('end_time')->nullable();

			$table->timestamps();
		});

		Schema::create('event_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->integer('event_id')->unsigned();

			$table->string('locale');

			$table->tinyInteger('status');

			$table->string('title');
			$table->string('slug')->nullable();
			
			$table->text('summary');
			$table->text('body');

			$table->timestamps();

			$table->unique(array('event_id', 'locale'));
			$table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('event_translations', function($table)
		{
			$table->dropForeign('event_translations_event_id_foreign');
		});
		Schema::drop('events');
		Schema::drop('event_translations');
	}

}
