<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('bggID');
            $table->timestamps();
        });

        Schema::table('plays', function (Blueprint $table){
           $table->dropColumn('name');
           $table->integer('gameID')->unsigned();
           $table->foreign('gameID')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');

        Schema::table('plays', function (Blueprint $table){
            $table->text('name');
            $table->dropColumn('gameID');
            $table->dropForeign('plays_gamedID_foreign');
        });
    }
}
