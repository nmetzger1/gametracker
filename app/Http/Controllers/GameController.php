<?php

namespace BoardGameTracker\Http\Controllers;

use BoardGameTracker\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use BoardGameTracker\plays;

class GameController extends Controller
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
        //Get Plays by ALL users
        $gamePlays = Game::GetPlaysByGame($id);

        //Get BGG ID
        $bggID = Game::find($id);

        //Get Details from BGG API
        $gameDetail = Game::GetBggDetailsById($bggID->bggID);

        //Get plays if user is logged in
        $userPlays = [];
        if(Auth::check()){
            $userPlays = plays::GetPlayByGameAndUserId($id, Auth::user()->id);
        }

        //Return View
        return view('gameDetail', compact('gamePlays', 'gameDetail', 'userPlays'));
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
        //
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
