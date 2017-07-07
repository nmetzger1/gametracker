<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    //Allows for mass update of columns in 'games' table
    protected $guarded = [];

    static function GetPlaysByGame($id){

        $plays = DB::table('plays')
            ->join('users', 'users.id', '=', 'plays.userID')
            ->join('games', 'games.id', '=', 'plays.gameID')
            ->select(DB::raw('users.name as Username, games.name as GameName, SUM(quantity) as NumPlays'))
            ->where(['plays.gameID' => $id])
            ->groupBy('users.name','games.name')
            ->orderBy('numPlays', 'desc')
            ->limit(50)
            ->get();

        return $plays;
    }
}
