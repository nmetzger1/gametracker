<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 7/4/2017
 * Time: 9:27 PM
 */

namespace BoardGameTracker;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;


class plays extends Model
{

    //Allows all columns to be updated in bulk
    protected $guarded = [];

    //Set relation to User
    public function users(){
        $this->hasMany('App\User');
    }

    //Set relation to Games
    public function games(){
        $this->hasMany('App\Game');
    }

    static function SyncUserPlays($bggUsername, $userID){


        $bggData = plays::GetBggData($bggUsername);

        DB::transaction(function () use ($bggData, $userID) {

            foreach ($bggData as $play){

                $game = Game::firstOrCreate(
                    ['name' => $play["name"]], ['bggID' => $play["bggID"]]
                );

                $newPlay = plays::firstOrCreate(
                    [
                        'bggPlayId' => $play["bggPlayID"],
                    ],
                    [
                        'userID' => $userID,
                        'gameID' => $game["id"],
                        'date' => $play["date"],
                        'quantity' => $play["quantity"],
                        'length' => $play["length"]
                    ]
                );
            }
        });

    }

    static function GetBggData($bggUsername){
        //get data from Board Game Geek
        $client = new Client();

        $i = 1;
        $totalRecords = 0;
        $playData = [];

        do {
            $res = $client->request('GET', 'https://www.boardgamegeek.com/xmlapi2/plays', [
                'query' => ['username' => $bggUsername, 'page' => $i]
            ]);

            //Parse XML data
            $data = new \SimpleXMLElement($res->getBody()->getContents());
            $json = json_encode($data);
            $jsonArray = json_decode($json, TRUE);

            //Update info for loop
            $i++;
            $totalRecords = intval($jsonArray["@attributes"]["total"]);

            foreach ($jsonArray["play"] as $play) {

                $playData[] = [
                    'name' => $play["item"]["@attributes"]["name"],
                    'date' => $play["@attributes"]["date"],
                    'quantity' => $play["@attributes"]["quantity"],
                    'bggID' => $play["item"]["@attributes"]["objectid"],
                    'bggPlayID' => $play["@attributes"]["id"],
                    'length' => $play["@attributes"]["length"]
                ];
            }

        } while (($i * 100) <= $totalRecords);

        return $playData;
    }

    static function PlaysByCurrentYear($userID){

        $playData = DB::table('plays')
            ->join('games', 'games.id', '=', 'plays.gameID')
            ->select(DB::raw('games.name, games.id as GameID, SUM(quantity) as NumPlays, DATE_FORMAT(MAX(plays.date), "%c/%d") as LastPlayed'))
            ->where('userID', '=', $userID)
            ->whereYear('plays.date', date("Y"))
            ->groupBy('name', 'games.id')
            ->orderBy('numPlays', 'desc')
            ->limit(10)
            ->get();

        return $playData;
    }

    static function TenByTenPercentages($userID){

        $data = plays::PlaysByCurrentYear($userID);

        $percents = [];
        $playCount = 0;

        $percents[] = ['Game','Plays'];

        foreach ($data as $game){

            $gameCount = 0;

            if($game->NumPlays > 9){
                $gameCount = 10;
            }
            else{
                $gameCount = intval($game->NumPlays);
            }

            $playCount += $gameCount;
        }

        //Add Games Played to Array
        $percents[] = ['Games Played', $playCount];

        //Add plays remaining to array
        $percents[] = ['Plays Left', 100 - $playCount];

        return $percents;

    }

    static function GetPlayByGameAndUserId($gameID, $userID){

        $numPlays = 0;
        $timeInMinutes = 0;
        $timeFormatted = "";

        $tableData = DB::table('plays')
            //->select('quantity', 'length')
            ->where([
                ['gameID', '=', $gameID],
                ['userID', '=', $userID]
            ])->get();

        foreach ($tableData as $play){
            $numPlays += $play->quantity;
            $timeInMinutes += $play->length;
        }

        if($timeInMinutes == 0){
            $timeFormatted = "No Data";
        }
        else{
            $hours = floor($timeInMinutes / 60);
            $days = floor($hours / 24);
            $minutes = ($timeInMinutes % 60);
            $timeFormatted = $days . " days " . $hours . " hours and " . $minutes . " minutes";
        }

        $playData = [
            'count' => $numPlays,
            'time' => $timeFormatted
        ];

        return $playData;

    }

    static function GetPlaysByUserID($userID){
        $playData = DB::table('plays')
            ->join('games', 'games.id', '=', 'plays.gameID')
            ->select(DB::raw('games.name, games.id as GameID, SUM(quantity) as NumPlays, MAX(plays.date) as LastPlayed'))
            ->where('userID', '=', $userID)
            ->groupBy('name', 'games.id')
            ->orderBy('numPlays', 'desc')
            ->limit(100)
            ->get();

        return $playData;
    }

    static function UsersWithMostPlays(){

        $userData = DB::table('plays')
            ->join('users', 'users.id', '=', 'plays.userID')
            ->select('users.name', DB::raw('SUM(quantity) as Plays'))
            ->limit(25)
            ->groupBy('users.name')
            ->orderBy('Plays', 'desc')
            ->get();

        return $userData;
    }
}