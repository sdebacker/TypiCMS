<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			
			$table->integer('fileable_id')->unsigned();
			$table->string('fileable_type');

			$table->integer('folder_id')->unsigned();
			
			$table->integer('user_id')->unsigned();
			
			$table->enum('type', array('a', 'v', 'd', 'i', 'o'));
			$table->string('name', 100);
			$table->string('filename');
			$table->string('path');
			$table->string('extension', 8);
			$table->string('mimetype', 100);
			$table->integer('width')->unsigned();
			$table->integer('height')->unsigned();
			$table->integer('filesize')->unsigned();
			$table->integer('download_count');

			$table->integer('position')->unsigned();

			$table->timestamps();

		});

		Schema::create('files_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->integer('file_id')->unsigned();

			$table->string('lang')->index();

			$table->tinyInteger('status');

			$table->text('description');
			$table->string('alt_attribute');
			$table->string('keywords');

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
		Schema::drop('files');
		Schema::drop('files_translations');
	}

}
