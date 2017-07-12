<?php

namespace BoardGameTracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class Game extends Model
{
    //Allows for mass update of columns in 'games' table
    protected $guarded = [];

    //Set relation to plays
    public function plays(){
        $this->hasMany('App\plays');
    }

    //Set relation to collections
    public function collections(){
        $this->hasMany('App\Collection');
    }

    static function GetPlaysByGame($id){

        $plays = DB::table('plays')
            ->join('users', 'users.id', '=', 'plays.userID')
            ->join('games', 'games.id', '=', 'plays.gameID')
            ->select(DB::raw('users.name as Username, games.name as GameName, SUM(quantity) as NumPlays, games.bggID'))
            ->where(['plays.gameID' => $id])
            ->groupBy('users.name','games.name', 'games.bggID')
            ->orderBy('numPlays', 'desc')
            ->limit(50)
            ->get();

        return $plays;
    }

    static function GetBggDetailsById($bggID){

        $client = new Client();

        $res = $client->request('GET', 'https://www.boardgamegeek.com/xmlapi2/thing', [
            'query' => ['id' => $bggID]
        ]);

        $data = new \SimpleXMLElement($res->getBody()->getContents());
        $json = json_encode($data);
        $jsonArray = json_decode($json, TRUE);

        return $jsonArray;
    }

    static function GetUserGameStats($userID, $gameID){



    }
}
