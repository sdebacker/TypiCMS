<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('class')->nullable();

            $table->timestamps();

        });
        Schema::create('menu_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('menu_id')->unsigned();

            $table->string('locale')->index();
            $table->tinyInteger('status')->default(0);

            $table->string('title');

            $table->timestamps();

            $table->unique(array('menu_id', 'locale'));
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');

        });
        Schema::create('menulinks', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->integer('page_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->integer('position')->unsigned()->default(0);
            $table->string('target', 10)->nullable();
            $table->string('module_name', 50)->nullable();
            $table->string('class')->nullable();
            $table->string('icon_class')->nullable();
            $table->boolean('has_categories')->nullable();

            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('menulinks')->onDelete('cascade');
        });
        Schema::create('menulink_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('menulink_id')->unsigned();

            $table->string('locale')->index();

            $table->tinyInteger('status')->default(0);

            $table->string('title', 100);
            $table->string('url');
            $table->string('uri');

            $table->timestamps();

            $table->unique(array('menulink_id', 'locale'));
            $table->foreign('menulink_id')->references('id')->on('menulinks')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menulink_translations');
        Schema::drop('menulinks');
        Schema::drop('menu_translations');
        Schema::drop('menus');
    }

}
