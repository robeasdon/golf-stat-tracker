<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tee_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('colour');
            $table->timestamps();

            $table->unique(['name', 'colour']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tee_types');
    }
}
