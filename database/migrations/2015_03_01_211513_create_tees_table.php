<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tees', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('yards')->unsigned();
            $table->timestamps();

            $table->integer('hole_id')->unsigned();
            $table->foreign('hole_id')->references('id')->on('holes');

            $table->integer('tee_set_id')->unsigned();
            $table->foreign('tee_set_id')->references('id')->on('tee_sets');

            $table->unique(['hole_id', 'tee_set_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tees');
    }
}
