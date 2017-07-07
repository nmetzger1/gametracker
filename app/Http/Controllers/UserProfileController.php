<?php

namespace App\Http\Controllers;

use App\User;
use App\plays;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\userprofile;
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
    public function show($username)
    {
        $user = User::where('name', $username)
            ->first();

        if(empty($user) == false){

            //Get ten most played games from 'plays' table
            $tenByTen = plays::GetTenByTen($user->id);

            //Get 50 most played games from 'plays' table
            $allPlays = plays::GetPlaysByUserID($user->id);
        }

        //Render view
        return view('userprofile', compact('user', 'tenByTen', 'allPlays'));
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

        plays::SyncUserPlays($bggName, $id);

        //Redirect user to the profile page view
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
