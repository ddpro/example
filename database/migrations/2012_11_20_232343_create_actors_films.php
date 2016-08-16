<?php

use Illuminate\Database\Migrations\Migration;

class CreateActorsFilms extends Migration {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_film', function($table)
        {
            $table->increments('id');
            $table->integer('actor_id')->unsigned();
            $table->integer('film_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('actor_film');
    }

}
