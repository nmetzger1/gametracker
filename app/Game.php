<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //Allows for mass update of columns in 'games' table
    protected $guarded = [];

    static function GetGameById($id){

        $data = Game::find($id);

        return $data;

    }
}
