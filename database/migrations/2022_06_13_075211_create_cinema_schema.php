<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('movies', function ($table) {
            $table->increments('id');
            $table->string('title', 300);
            $table->string('vote');
            $table->integer('like');
            $table->string('type', 200);
            $table->timestamps();
        });

        Schema::create('show_time', function ($table) {
            $table->increments('id');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->datetime('start');
            $table->datetime('end');
            $table->timestamps();
        });

        Schema::create('pricing', function ($table) {
            $table->increments('id');
            $table->foreign('show_id')->references('id')->on('show_time');
            $table->string('type', 200);
            $table->string('price');
            $table->timestamps();
        });

        Schema::create('book_ticket', function ($table) {
            $table->increments('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('show_id')->references('id')->on('show_time');
            $table->string('seat_numbers');// 11,12,13,14
            $table->string('row'); // A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P
            $table->integer('number_of_seat');
            $table->enum('status', ['booked', 'pending', 'fail']);
            $table->timestamps();
        });

        Schema::create('cinema', function ($table) {
            $table->increments('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->text('location');
            $table->string('theater_name');
            $table->enum('status', ['active','inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
