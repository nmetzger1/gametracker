<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 7/5/2017
 * Time: 3:51 PM
 */

namespace App;

use Illuminate\Support\Facades\DB;


class mysql
{
    static function GetTenByTen($userID){

        $playData = DB::table('plays')
            ->select(DB::raw('name, SUM(quantity) as NumPlays, MAX(date) as LastPlayed'))
            ->where('userID', '=', $userID)
            ->whereYear('date', date("Y"))
            ->groupBy('name')
            ->orderBy('numPlays', 'desc')
            ->limit(10)
            ->get();

        return $playData;
    }

    static function GetAllPlays(){

        $mostPlayed = DB::table('plays')
            ->select(DB::raw('name, SUM(quantity) as NumPlays, MAX(date) as LastPlayed'))
            ->whereYear('date', date("Y"))
            ->groupBy('name')
            ->orderBy('numPlays', 'desc')
            ->limit(50)
            ->get();

        return $mostPlayed;
    }
}