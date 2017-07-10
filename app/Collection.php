<?php

namespace BoardGameTracker;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class Collection extends Model
{
    //Allows for bulk updating of columns
    protected $guarded = [];

    //Set relation with users table
    public function users(){
        return $this->belongsTo('App\User');
    }

    //Set relation with games table
    public function games(){
        return $this->belongsTo('App\Game');
    }

    static function GetUserCollection($username){

        $client = new Client();

        do{
            $res = $client->request('GET', 'https://www.boardgamegeek.com/xmlapi2/collection', [
                'query' => ['username' => $username, 'own' => 1]
            ]);

        }while($res->getStatusCode() == 202);


        $data = new \SimpleXMLElement($res->getBody()->getContents());
        $json = json_encode($data);
        $jsonArray = json_decode($json, TRUE);

        return $jsonArray;
    }

    static function StoreUserCollection($username, $userID){

        $collection = Collection::GetUserCollection($username);

        foreach ($collection["item"] as $owned){

            $game = Game::firstOrCreate(
                ['name' => $owned["name"]], ['bggID' => $owned["@attributes"]["objectid"]]
            );

            $newCollection = Collection::firstOrCreate(
                ['userID' => $userID, 'gameID' => $game["id"]]
            );
        }
    }

    static function GetNoPlaysLastSixMonth($userid){

        $games = DB::table('collections')
            ->select(DB::raw('games.name, collections.gameID, MAX(plays.date) as LastPlayed'))
            ->join('games', 'games.id', '=', 'collections.gameID')
            ->leftJoin('plays', function ($join) use ($userid){
                $join->on('collections.gameID', '=', 'plays.gameID')
                    ->where('plays.userID', '=', $userid);
            })
            ->whereNotIn('collections.gameID', function ($query) use ($userid) {
                $query->select('gameID')
                    ->from('plays')
                    ->where([
                        ['date', '>', date('Y/m/d', strtotime("-6 months"))],
                        ['userID', '=', $userid]
                    ]);
            })
            ->where('collections.userID', '=', $userid)
            ->groupBy('games.name', 'collections.gameID')
            ->get();

        return $games;
    }
}
