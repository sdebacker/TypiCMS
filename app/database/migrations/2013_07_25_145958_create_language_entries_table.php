<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageEntriesTableX extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('language_entries', function(Blueprint $table)
		{
			
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('language_id')->unsigned();
			$table->string('namespace', 150)->default('*');
			$table->string('group', 150);
			$table->string('item', 150);
			$table->text('text');
			$table->boolean('unstable')->default(0);
			$table->boolean('locked')->default(0);
			$table->timestamps();
			$table->foreign('language_id')->references('id')->on('languages');
			$table->unique(array('language_id', 'namespace', 'group', 'item'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('language_entries');
	}

}