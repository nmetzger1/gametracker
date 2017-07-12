<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlayColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('plays', function (Blueprint $table){
           $table->integer('bggPlayID');
           $table->integer('length')->nullable();
           $table->boolean('win')->nullable();
           $table->integer('score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plays', function (Blueprint $table){
            $table->dropColumn('bggPlayID');
            $table->dropColumn('length');
            $table->dropColumn('win');
            $table->dropColumn('score');
        });
    }
}
