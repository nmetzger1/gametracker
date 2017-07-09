<?php

namespace BoardGameTracker;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class Collection extends Model
{
    protected $guarded = [];

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
}
