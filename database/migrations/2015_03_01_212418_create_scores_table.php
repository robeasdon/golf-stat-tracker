<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('strokes');
            $table->tinyInteger('putts');
            $table->boolean('fairway')->nullable();
            $table->boolean('gir')->nullable();
            $table->timestamps();

            $table->integer('round_id')->unsigned();
            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');

            $table->integer('hole_id')->unsigned();
            $table->foreign('hole_id')->references('id')->on('holes');

            $table->unique(['round_id', 'hole_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scores');
    }
}
