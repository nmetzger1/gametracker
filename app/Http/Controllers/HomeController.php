<?php

namespace App\Http\Controllers;

use App\mysql;
use App\plays;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playData = plays::GetAllPlays();

        return view('home', ['playData' => $playData]);
    }
}
