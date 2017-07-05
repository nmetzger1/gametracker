<?php

namespace App\Http\Controllers;

use App\plays;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\userprofile;
use jdavidbakr\ReplaceableModel\ReplaceableModel;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = new userprofile();
        $profile->id = $id;
        return view('layouts.userprofile', ['profile' => $profile]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //store username
        $bggName = $request->get('name');

        //get data from Board Game Geek
        $client = new Client();
        $res = $client->request('GET', 'https://www.boardgamegeek.com/xmlapi2/plays', [
            'query' => ['username' => $bggName]
        ]);

        //Parse XML data
        $data = new \SimpleXMLElement($res->getBody()->getContents());
        $json = json_encode($data);
        $jsonArray = json_decode($json,TRUE);

        //Store bbg data as array
        $playData = [];

        foreach ($jsonArray["play"] as $play){
            $playData[] = [
                'userID' => $id,
                'name' => $play["item"]["@attributes"]["name"],
                'date' => $play["@attributes"]["date"],
                'quantity' => $play["@attributes"]["quantity"]
            ];
        }

        plays::insertIgnore($playData);

        return redirect(route('user.show',['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
