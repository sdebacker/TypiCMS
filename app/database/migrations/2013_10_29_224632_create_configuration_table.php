<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
        /** @var \Illuminate\Database\Schema\Blueprint $table */
		Schema::create('configuration', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('package')->nullable();
            $table->string('group')->default('config');
            $table->string('key');
            $table->string('value')->nullable();
            $table->string('type');
            $table->string('environment')->nullable();
            $table->unique(array('package', 'key', 'environment'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('configuration');
	}

}