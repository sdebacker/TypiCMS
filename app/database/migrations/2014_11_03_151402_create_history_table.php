<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('historable_id')->unsigned();
            $table->string('historable_type');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->string('icon_class')->nullable();
            $table->string('locale')->nullable();
            $table->string('historable_table');
            $table->string('action');
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
        Schema::drop('history');
    }

}
