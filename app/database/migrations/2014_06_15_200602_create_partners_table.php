<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->boolean('homepage')->default(0);
            $table->integer('position')->unsigned()->default(1);
            $table->string('image')->nullable();

            $table->timestamps();
        });

        Schema::create('partner_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('partner_id')->unsigned();

            $table->string('locale');

            $table->tinyInteger('status')->default(0);

            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('website')->nullable();
            $table->text('body');

            $table->timestamps();

            $table->unique(array('partner_id', 'locale'));
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('partner_translations');
        Schema::drop('partners');
    }

}
