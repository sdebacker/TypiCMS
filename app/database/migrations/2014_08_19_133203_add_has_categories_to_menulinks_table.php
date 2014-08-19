<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHasCategoriesToMenulinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('menulinks', function(Blueprint $table)
		{
			$table->boolean('has_categories')->nullable()->after('icon_class');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('menulinks', function(Blueprint $table)
		{
			$table->dropColumn('has_categories');
		});
	}

}
