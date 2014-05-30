<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('folder_id')->unsigned()->default(0);
            $table->integer('gallery_id')->unsigned()->default(0);

            $table->integer('user_id')->unsigned()->default(0);

            $table->enum('type', array('a', 'v', 'd', 'i', 'o'));
            $table->string('filename');
            $table->string('path');
            $table->string('extension', 8);
            $table->string('mimetype', 100);
            $table->integer('width')->unsigned()->nullable();
            $table->integer('height')->unsigned()->nullable();
            $table->integer('filesize')->unsigned();
            $table->integer('download_count')->default(0);

            $table->integer('position')->unsigned()->default(0);

            $table->timestamps();

        });

        Schema::create('file_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('file_id')->unsigned();

            $table->string('locale')->index();

            $table->text('description');
            $table->string('alt_attribute');
            $table->string('keywords');

            $table->timestamps();

            $table->unique(array('file_id', 'locale'));
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('file_translations');
        Schema::drop('files');
    }

}
