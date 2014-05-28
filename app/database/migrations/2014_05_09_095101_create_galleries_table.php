<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('gallery_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('gallery_id')->unsigned();

            $table->string('locale');

            $table->tinyInteger('status')->default(0);

            $table->string('title');
            $table->string('slug')->nullable();

            $table->text('body');

            $table->timestamps();

            $table->unique(array('gallery_id', 'locale'));
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gallery_translations');
        Schema::drop('galleries');
    }

}
