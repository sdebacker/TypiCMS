<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddImageToTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function(Blueprint $table)
        {
            $table->string('image')->nullable();
        });
        Schema::table('news', function(Blueprint $table)
        {
            $table->string('image')->nullable();
        });
        Schema::table('events', function(Blueprint $table)
        {
            $table->string('image')->nullable();
        });
        Schema::table('projects', function(Blueprint $table)
        {
            $table->string('image')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function(Blueprint $table)
        {
            $table->dropColumn('image');
        });
        Schema::table('news', function(Blueprint $table)
        {
            $table->dropColumn('image');
        });
        Schema::table('events', function(Blueprint $table)
        {
            $table->dropColumn('image');
        });
        Schema::table('projects', function(Blueprint $table)
        {
            $table->dropColumn('image');
        });
    }

}
