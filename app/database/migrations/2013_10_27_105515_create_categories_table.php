<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('image')->nullable();

            $table->integer('position')->unsigned()->default(0);

            $table->timestamps();
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->string('locale')->index();

            $table->tinyInteger('status')->default(0);

            $table->string('title');
            $table->string('slug')->nullable();

            $table->timestamps();

            $table->unique(array('category_id', 'locale'));
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_translations');
        Schema::drop('categories');
    }

}
