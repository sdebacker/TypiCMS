<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('name');

            $table->timestamps();
        });

        Schema::create('block_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('block_id')->unsigned();

            $table->string('locale');

            $table->tinyInteger('status')->default(0);
            $table->text('body');

            $table->timestamps();

            $table->unique(array('block_id', 'locale'));
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('block_translations');
        Schema::drop('blocks');
    }

}
