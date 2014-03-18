<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('group');
            $table->string('key');
            $table->timestamps();
        });

        Schema::create('translation_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('translation_id')->unsigned();

            $table->string('locale')->index();

            $table->text('translation')->nullable();

            $table->timestamps();

            $table->unique(array('translation_id', 'locale'));
            $table->foreign('translation_id')->references('id')->on('translations')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('translation_translations');
        Schema::drop('translations');
    }

}
