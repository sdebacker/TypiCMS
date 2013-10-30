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
			$table->increments('id');

			$table->date('start_date');
			$table->date('end_date');
			$table->string('start_time');
			$table->string('end_time');

			$table->timestamps();
		});

		Schema::create('events_translations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('event_id')->unsigned();

			$table->string('lang');

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
		Schema::drop('events');
		Schema::drop('events_translations');
	}

}
