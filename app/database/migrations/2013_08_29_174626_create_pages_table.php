<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('meta_robots_no_index')->default(0);
            $table->string('meta_robots_no_follow')->default(0);

            $table->string('image')->nullable();
            $table->integer('position')->unsigned()->default(0);
            $table->integer('parent_id')->unsigned()->nullable()->default(null);

            $table->tinyInteger('is_home')->default(0);

            $table->text('css')->nullable();
            $table->text('js')->nullable();

            $table->string('template')->nullable();

            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade');
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('page_id')->unsigned();

            $table->string('locale')->index();

            $table->string('slug')->nullable();
            $table->string('uri')->unique()->nullable();

            $table->string('title');
            $table->text('body');

            $table->tinyInteger('status')->default(0);

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();

            $table->timestamps();

            $table->unique(array('page_id', 'locale'));
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('page_translations');
        Schema::drop('pages');
    }

}
