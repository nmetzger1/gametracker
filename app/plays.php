<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 7/4/2017
 * Time: 9:27 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;


class plays extends Model
{

    //Allows all columns to be updated in bulk
    protected $guarded = [];

    static function SyncUserPlays($bggUsername, $userID){

        $bggData = plays::GetBggData($bggUsername);

        foreach ($bggData as $play){

            $game = Game::firstOrCreate(
                ['name' => $play["name"]], ['bggID' => $play["bggID"]]
            );

            $newPlay = plays::firstOrCreate(
              ['userID' => $userID, 'gameID' => $game["id"], 'date' => $play["date"]], ['quantity' => $play["quantity"]]
            );
        }

    }

    static function GetBggData($bggUsername){
        //get data from Board Game Geek
        $client = new Client();
        $res = $client->request('GET', 'https://www.boardgamegeek.com/xmlapi2/plays', [
            'query' => ['username' => $bggUsername]
        ]);

        //Parse XML data
        $data = new \SimpleXMLElement($res->getBody()->getContents());
        $json = json_encode($data);
        $jsonArray = json_decode($json,TRUE);

        //Store bbg data as array
        $playData = [];

        foreach ($jsonArray["play"] as $play){
            $playData[] = [
                'name' => $play["item"]["@attributes"]["name"],
                'date' => $play["@attributes"]["date"],
                'quantity' => $play["@attributes"]["quantity"],
                'bggID' => $play["item"]["@attributes"]["objectid"]
            ];
        }

        return $playData;
    }

    static function GetTenByTen($userID){

        $playData = DB::table('plays')
            ->join('games', 'games.id', '=', 'plays.gameID')
            ->select(DB::raw('games.name, games.id as GameID, SUM(quantity) as NumPlays, MAX(plays.date) as LastPlayed'))
            ->where('userID', '=', $userID)
            ->whereYear('plays.date', date("Y"))
            ->groupBy('name', 'games.id')
            ->orderBy('numPlays', 'desc')
            ->limit(10)
            ->get();

        return $playData;
    }

    static function GetAllPlays(){

        $mostPlayed = DB::table('plays')
            ->join('games', 'games.id', '=', 'plays.gameID')
            ->select(DB::raw('games.name, games.id as GameID, SUM(quantity) as NumPlays, MAX(date) as LastPlayed'))
            ->whereYear('date', date("Y"))
            ->groupBy('name', 'games.id')
            ->orderBy('numPlays', 'desc')
            ->limit(50)
            ->get();

        return $mostPlayed;
    }
}