<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeeSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tee_sets', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('sss')->unsigned();
            $table->timestamps();

            $table->integer('tee_type_id')->unsigned();
            $table->foreign('tee_type_id')->references('id')->on('tee_types');

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

            $table->unique(['tee_type_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tee_sets');
    }
}
