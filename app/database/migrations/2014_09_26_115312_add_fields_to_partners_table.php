<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldsToPartnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('partners', function(Blueprint $table)
		{
			$table->boolean('homepage')->default(0);
			$table->integer('position')->unsigned()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('partners', function(Blueprint $table)
		{
			$table->dropColumn('homepage');
			$table->dropColumn('position');
		});
	}

}
